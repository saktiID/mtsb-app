<?php

namespace App\Services\Data;

use App\Models\Data\Periode;
use Yajra\DataTables\Facades\DataTables;

class PeriodeDataTableService
{
    public function getPeriodeDataTable()
    {
        $periode = Periode::orderBy('tahun_ajaran', 'ASC')
            ->orderBy('semester', 'ASC')
            ->get();

        $dataTable = DataTables::of($periode)
            ->addColumn('id', function ($periode) {
                return $periode->id;
            })
            ->addColumn('semester', function ($periode) {
                return $periode->semester;
            })
            ->addColumn('tahun_ajaran', function ($periode) {
                return $periode->tahun_ajaran;
            })
            ->addColumn('status', function ($periode) {
                $data['status'] = $periode->periode_status;
                $data['id'] = $periode->id;
                $data['class'] = 'periode_status';

                return view('element.radio', $data);
            })
            ->rawColumns(['status'])
            ->make(true);

        return $dataTable;
    }
}
