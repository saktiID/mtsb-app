<?php

namespace App\Services\Agenda;

use App\Models\Agenda\AssessmentAspect;
use Yajra\DataTables\Facades\DataTables;

class AspectDataTableService
{
    public function getAspectDataTable($request)
    {

        $aspect = AssessmentAspect::where('aspect_for', $request->a)->latest();
        $dataTable = DataTables::of($aspect)
            ->addIndexColumn()
            ->addColumn('aspect', function ($aspect) {
                return $aspect->aspect;
            })
            ->addColumn('aspect_status', function ($aspect) {
                $data['status'] = $aspect->aspect_status;
                $data['id'] = $aspect->id;
                $data['class'] = 'aspect-status';
                $element = view('element.switch', $data);
                return $element;
            })
            ->addColumn('more', function ($aspect) {
                $data['id'] = $aspect->id;
                $data['aspect'] = $aspect->aspect;
                $data['aspect_for'] = $aspect->aspect_for;
                return view('element.delete-aspect-action', $data);
            })
            ->rawColumns(['aspect_status'])
            ->make(true);

        return $dataTable;
    }
}
