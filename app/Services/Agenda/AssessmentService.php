<?php

namespace App\Services\Agenda;

use App\Jobs\InsertAssessmentRecordJob;
use App\Models\Agenda\AssessmentRecord;
use App\Models\AssessmentProcess;
use App\Models\Data\KelasSiswa;
use App\Models\PeerRandomLock;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AssessmentService
{
    public function peer_random($request)
    {
        // Cek apakah sudah ada record untuk siswa ini
        $record = PeerRandomLock::where('periode_id', $request->periode_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('siswa_user_id', $request->siswa_user_id)
            ->where('bulan', $request->bulan)
            ->where('minggu_ke', $request->minggu_ke)
            ->first(); // gunakan first() bukan get()

        if ($record) {
            // Ambil user berdasarkan teman_user_id yang sudah tersimpan
            return User::find($record->teman_user_id);
        }

        // Ambil semua user_id teman sekelas (kecuali siswa itu sendiri)
        $semuaTeman = KelasSiswa::where('periode_id', $request->periode_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('user_id', '!=', $request->siswa_user_id)
            ->pluck('user_id');

        // Ambil semua teman yang sudah pernah terpilih oleh siswa ini
        $temanTerpilih = PeerRandomLock::where('periode_id', $request->periode_id)
            ->where('kelas_id', $request->kelas_id)
            // ->where('siswa_user_id', $request->siswa_user_id) // penting: filter berdasarkan siswa
            ->where('bulan', $request->bulan)
            ->where('minggu_ke', $request->minggu_ke)
            ->pluck('teman_user_id');

        // Filter teman yang belum terpilih
        $temanBelumTerpilih = $semuaTeman->diff($temanTerpilih)->values();

        // Jika tidak ada teman tersisa, kembalikan null atau error
        if ($temanBelumTerpilih->isEmpty()) {
            return null; // atau bisa return response()->json(['error' => 'Tidak ada teman tersedia']);
        }

        // Pilih satu teman secara acak
        $temanTerpilihBaru = $temanBelumTerpilih->random();

        // Simpan ke tabel peer_random_lock
        PeerRandomLock::create([
            'periode_id' => $request->periode_id,
            'kelas_id' => $request->kelas_id,
            'siswa_user_id' => $request->siswa_user_id,
            'teman_user_id' => $temanTerpilihBaru,
            'bulan' => $request->bulan,
            'minggu_ke' => $request->minggu_ke,
        ]);

        // Kembalikan data user dari teman yang terpilih
        return User::find($temanTerpilihBaru);
    }

    public function check_peer_record($request)
    {
        // ambil semua siswa dalam kelas
        $siswa_kelas = KelasSiswa::with('user')
            ->where('periode_id', $request['periode_id'])
            ->where('kelas_id', $request['kelas_id'])
            ->get();

        // Ambil data PeerRandomLock
        $records = PeerRandomLock::with(['user', 'teman'])
            ->where('periode_id', $request['periode_id'])
            ->where('kelas_id', $request['kelas_id'])
            ->where('bulan', $request['bulan'])
            ->where('minggu_ke', $request['minggu_ke'])
            ->get();

        $data = [];
        $table = [];

        foreach ($siswa_kelas as $siswa) {
            // Cek apakah user_id dari kelas_siswa ada di antara siswa_user_id dari PeerRandomLock
            $match = $records->firstWhere('siswa_user_id', $siswa->user_id);

            if ($match) {
                $table[] = [
                    'evaluator' => $siswa->user->nama,
                    'assessed' => $match->teman->nama,
                    'status' => $match->assessment_process ? $match->assessment_process->status : 'No process',
                ];
            } else {
                $table[] = [
                    'evaluator' => $siswa->user->nama,
                    'assessed' => '-',
                    'status' => 'no process',
                ];
            }
        }

        return $table;
    }

    public function storeAssessment($request, $evaluator)
    {
        $notif = [
            'nama_siswa' => $request->nama_siswa,
            'evaluator' => $evaluator,
            'walas_id' => $request->walas_id,
            'minggu_ke' => $request->minggu_ke,
            'bulan' => $request->bulan,
        ];

        $aspects = json_decode($request->aspects, true);
        $data = [];

        foreach ($aspects as $item) {
            if ($item['name'] != 'note') {
                $data[] = [
                    'id' => Str::uuid(),
                    'kelas_id' => $request->kelas_id,
                    'periode_id' => $request->periode_id,
                    'siswa_user_id' => ($evaluator == 'Peer - '.Auth::user()->nama) ? $request->teman_user_id : $request->siswa_user_id,
                    'aspect_id' => $item['name'],
                    'is_note' => false,
                    'answer' => $item['value'],
                    'bulan' => $request->bulan,
                    'minggu_ke' => $request->minggu_ke,
                    'evaluator' => $evaluator,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } else {
                $data[] = [
                    'id' => Str::uuid(),
                    'kelas_id' => $request->kelas_id,
                    'periode_id' => $request->periode_id,
                    'siswa_user_id' => ($evaluator == 'Peer - '.Auth::user()->nama) ? $request->teman_user_id : $request->siswa_user_id,
                    'aspect_id' => null,
                    'is_note' => true,
                    'answer' => $item['value'],
                    'bulan' => $request->bulan,
                    'minggu_ke' => $request->minggu_ke,
                    'evaluator' => $evaluator,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // memasukkan ke proses
        $process = new AssessmentProcess();
        $process->status = 'processing';
        $process->kelas_id = $request->kelas_id;
        $process->periode_id = $request->periode_id;
        $process->siswa_user_id = ($evaluator == 'Peer - '.Auth::user()->nama) ? $request->teman_user_id : $request->siswa_user_id;
        $process->bulan = $request->bulan;
        $process->minggu_ke = $request->minggu_ke;
        $process->evaluator = $evaluator;
        $process->save();

        // memasukkan ke job
        InsertAssessmentRecordJob::dispatch($data, $notif, $process);

        return true;
    }

    public function checkExist($request, $evaluator)
    {
        return AssessmentRecord::where('periode_id', $request->periode_id)
            ->where('siswa_user_id', ($evaluator == 'Peer') ? $request->teman_user_id : $request->siswa_user_id)
            ->where('bulan', $request->bulan)
            ->where('minggu_ke', $request->minggu_ke)
            ->where('evaluator', 'like', $evaluator.'%')
            ->exists();
    }

    public function checkProcess($request, $evaluator)
    {
        return AssessmentProcess::where('status', 'processing')
            ->where('periode_id', $request->periode_id)
            ->where('siswa_user_id', ($evaluator == 'Peer') ? $request->teman_user_id : $request->siswa_user_id)
            ->where('bulan', $request->bulan)
            ->where('minggu_ke', $request->minggu_ke)
            ->where('evaluator', 'like', $evaluator.'%')
            ->exists();
    }

    public function getNoteAssessment($request)
    {
        $assessmentData = AssessmentRecord::with('aspect')
            ->where('siswa_user_id', $request[0]['siswa_user_id'])
            ->where('periode_id', $request[0]['periode_id'])
            ->where('bulan', $request[0]['bulan'])
            ->where('minggu_ke', $request[0]['minggu_ke'])
            ->where('evaluator', 'like', $request[0]['evaluator'].'%')
            ->where('is_note', true)
            ->first();

        return $assessmentData;
    }

    public function printAssessment($request)
    {
        $request = json_decode($request->a, true);

        $assessmentData = AssessmentRecord::with(['aspect', 'kelas:id,bagian_kelas,jenjang_kelas'])
            ->where('siswa_user_id', $request[0]['siswa_user_id'])
            ->where('periode_id', $request[0]['periode_id'])
            ->where('bulan', $request[0]['bulan'])
            ->where('minggu_ke', $request[0]['minggu_ke'])
            ->where('evaluator', 'like', $request[0]['evaluator'].'%')
            ->where('is_note', false)
            ->orderBy('aspect_id', 'asc')
            ->get();

        $result = [];
        foreach ($assessmentData as $data) {
            $result[] = [
                'aspect' => $data->aspect->aspect,
                'answer' => $data->answer,
                'kelas' => $data->kelas->jenjang_kelas.'-'.$data->kelas->bagian_kelas,
            ];
        }

        return response()->json($result);
    }
}
