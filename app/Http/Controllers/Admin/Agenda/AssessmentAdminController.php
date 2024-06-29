<?php

namespace App\Http\Controllers\Admin\Agenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Agenda\AspectDataTableService as AspectData;
use App\Services\Agenda\AspectService as Aspect;

class AssessmentAdminController extends Controller
{
    protected $aspect;
    protected $aspectData;

    public function __construct(Aspect $aspect, AspectData $aspectData)
    {
        $this->aspect = $aspect;
        $this->aspectData = $aspectData;
    }

    public function assessment_aspect(Request $request)
    {
        if ($request->ajax()) {
            return $this->aspectData->getAspectDataTable($request);
        }
        return view('admin.agenda.assessment-aspect.aspect',);
    }

    public function tambah_assessment_aspect(Request $request)
    {

        $query = $this->aspect->tambahAspect($request);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Assessment Aspect for ' . $request->aspect_for . ' berhasil ditambahkan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Assessment Aspect gagal ditambahkan']);
        }
    }

    public function switch_aspect_status(Request $request)
    {
        $query = $this->aspect->switchAspectStatus($request->id);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Aspect Status berhasil diubah']);
        } else {
            return response()->json(['success' => false, 'message' => 'Aspect Status gagal diubah']);
        }
    }

    public function hapus_assessment_aspect(Request $request)
    {
        $query = $this->aspect->hapusAspect($request->id);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Assessment Aspect Berhasil Dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Assessment Aspect Gagal Dihapus']);
        }
    }

    public function assessment_history()
    {
        return view('admin.agenda.assessment-history.history');
    }
}
