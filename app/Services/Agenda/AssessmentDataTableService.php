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
        // ambil aspek
        $aspects = AssessmentAspect::select(["id", "aspect", "aspect_for"])
            ->orderBy('id', 'asc')
            ->where('aspect_status', 1)
            ->where('aspect_for', 'like', $request[0]['evaluator'].'%')
            ->get();
        
        // ambil siswa berdasarkan kelas
        $siswa_list = KelasSiswa::with("user")
            ->where("kelas_id", $request[0]['kelas_id'])
                ->orderBy(DB::raw('(SELECT nama FROM users WHERE users.id = kelas_siswas.user_id)'), 'asc')
            ->get();

        // ambil semua answer aspect
        $records = AssessmentRecord::where('kelas_id', $request[0]['kelas_id'])
            ->orderBy('aspect_id', 'asc')
            ->where('periode_id', $request[0]['periode_id'])
            ->where('bulan', $request[0]['bulan'])
            ->where('minggu_ke', $request[0]['minggu_ke'])
            ->where('evaluator', 'like', $request[0]['evaluator'].'%')
            ->with(['user', 'aspect'])
            ->get();


        // membuat tabel
        $table = [];

        foreach ($siswa_list as $index => $siswa) {
            $row = [
                'no' => $index + 1,
                'nama_siswa' => $siswa->user->nama, 
            ];

            foreach ($aspects as $aspect) {
                $record = $records->first(function ($r) use ($siswa, $aspect) {
                    return $r->siswa_user_id === $siswa->user_id && $r->aspect_id === $aspect->id;
                });

                $row['aspect_answer'][] = [
                    'aspect_id' => $aspect->id,
                    'answer' => $record ? $record->answer : '-'
                ];
            }

            $table[] = $row;
        }

        $data['aspects'] = $aspects;
        $data['table'] = $table;

        return $data;
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
