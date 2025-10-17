<?php

namespace App\Services\Agenda;

use App\Models\Data\KelasSiswa;
use App\Models\AssessmentProcess;
use Illuminate\Support\Facades\DB;
use App\Models\Agenda\AssessmentAspect;
use App\Models\Agenda\AssessmentRecord;
use Yajra\DataTables\Facades\DataTables;

class AssessmentDataTableService
{
    public function getAllData($request)
    {
        // Ambil semua record yang relevan
        $records = AssessmentRecord::where('kelas_id', $request[0]['kelas_id'])
            ->where('periode_id', $request[0]['periode_id'])
            ->where('bulan', $request[0]['bulan'])
            ->where('minggu_ke', $request[0]['minggu_ke'])
            ->where('evaluator', 'like', $request[0]['evaluator'].'%')
            ->whereNotNull('aspect_id')
            ->where('is_note', 0)
            ->with(['user', 'aspect'])
            ->get();

        // Ambil semua aspect_id unik dari records
        $aspectIds = $records->pluck('aspect_id')->unique()->values();

        // Ambil aspek yang benar-benar digunakan dalam records
        $aspects = AssessmentAspect::whereIn('id', $aspectIds)
            ->select(['id', 'aspect', 'aspect_for'])
            ->orderBy('id', 'asc')
            ->get();

        // Ambil daftar siswa
        $siswa_list = KelasSiswa::with('user')
            ->where('kelas_id', $request[0]['kelas_id'])
            ->orderBy(DB::raw('(SELECT nama FROM users WHERE users.id = kelas_siswas.user_id)'), 'asc')
            ->get();

        // Bangun tabel jawaban
        $table = [];

        foreach ($siswa_list as $index => $siswa) {
            $row = [
                'no' => $index + 1,
                'nama_siswa' => $siswa->user->nama,
                'aspect_answer' => []
            ];

            foreach ($aspects as $aspect) {
                $record = $records->first(function ($r) use ($siswa, $aspect) {
                    return (string) $r->siswa_user_id === (string) $siswa->user_id
                        && (string) $r->aspect_id === (string) $aspect->id;
                });

                $row['aspect_answer'][] = [
                    'aspect_id' => $aspect->id,
                    'answer' => $record ? $record->answer : '-',
                ];
            }

            $table[] = $row;
        }

        return [
            'aspects' => $aspects,
            'table' => $table,
        ];
    }

    public function getDataTable($request)
    {
        $assessmentData = AssessmentRecord::with('aspect')
            ->where('siswa_user_id', $request[0]['siswa_user_id'])
            ->where('periode_id', $request[0]['periode_id'])
            ->where('bulan', $request[0]['bulan'])
            ->where('minggu_ke', $request[0]['minggu_ke'])
            ->where('evaluator', 'like', $request[0]['evaluator'].'%')
            ->where('is_note', false)
            ->orderBy('aspect_id', 'asc')
            ->get();

        $dataTable = DataTables::of($assessmentData)
            ->addColumn('aspect', function ($assessmentData) {
                return $assessmentData->aspect->aspect;
            })
            ->addColumn('answer', function ($assessmentData) {
                $el = '<span class="badge outline-badge-dark">'.$assessmentData->answer.'</span>';

                return $el;
            })
            ->rawColumns(['answer'])
            ->make(true);

        return $dataTable;
    }

    public function getProcessData($request)
    {
        $processData = AssessmentProcess::has('user')
            ->with('user:id,nama')
            ->where('kelas_id', $request[0]['kelas_id'])
            ->where('periode_id', $request[0]['periode_id'])
            ->where('bulan', $request[0]['bulan'])
            ->where('minggu_ke', $request[0]['minggu_ke'])
            ->where('evaluator', 'like', $request[0]['evaluator'].'%')
            ->get();

        $dataTable = DataTables::of($processData)
            ->addColumn('nama', function ($processData) {
                return $processData->user->nama;
            })
            ->addColumn('status', function ($processData) {
                $status = $processData->status;

                if ($status == 'processing') {
                    $el = '<span class="badge badge-info">Processing</span>';
                } elseif ($status == 'complete') {
                    $el = '<span class="badge badge-success">Complete</span>';
                } else {
                    $el = '<span class="badge badge-danger">Failed</span>';
                }

                return $el;
            })
            ->addColumn('exception', function ($processData) {
                return $processData->exception;
            })
            ->addColumn('evaluator', function ($processData) {
                return $processData->evaluator;
            })
            ->addColumn('last_activity', function ($processData) {
                return $processData->updated_at;
            })
            ->rawColumns(['status', 'last_activity'])
            ->make(true);

        return $dataTable;
    }
}
