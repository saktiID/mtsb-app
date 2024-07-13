<?php

namespace App\Services\Agenda;

use App\Models\Agenda\AssessmentRecord;
use Yajra\DataTables\Facades\DataTables;

class AssessmentDataTableService
{
    public function getDataTable($request)
    {
        $assessmentData = AssessmentRecord::with('aspect')
            ->where('siswa_user_id', $request[0]['siswa_user_id'])
            ->where('periode_id', $request[0]['periode_id'])
            ->where('bulan', $request[0]['bulan'])
            ->where('minggu_ke', $request[0]['minggu_ke'])
            ->where('evaluator', $request[0]['evaluator'])
            ->where('is_note', false)
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
}
