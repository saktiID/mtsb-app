<?php

namespace App\Services\Agenda;

use App\Jobs\InsertAssessmentRecordJob;
use App\Models\Agenda\AssessmentRecord;
use Illuminate\Support\Str;

class AssessmentService
{
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
                    'siswa_user_id' => $request->siswa_user_id,
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
                    'siswa_user_id' => $request->siswa_user_id,
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

        InsertAssessmentRecordJob::dispatch($data, $notif);

        return true;
    }

    public function checkExist($request, $evaluator)
    {
        return AssessmentRecord::where('periode_id', $request->periode_id)
            ->where('siswa_user_id', $request->siswa_user_id)
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
