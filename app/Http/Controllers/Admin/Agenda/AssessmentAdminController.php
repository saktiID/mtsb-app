<?php

namespace App\Http\Controllers\Admin\Agenda;

use App\Http\Controllers\Controller;
use App\Models\Data\Periode;
use App\Models\Data\Siswa;
use App\Services\Agenda\AspectDataTableService as AspectData;
use App\Services\Agenda\AspectService as Aspect;
use App\Services\Agenda\AssessmentDataTableService as AssessmentData;
use App\Services\Agenda\AssessmentService as Assessment;
use Illuminate\Http\Request;

class AssessmentAdminController extends Controller
{
    protected $aspect;

    protected $aspectData;

    protected $assessment;

    protected $assessmentData;

    public function __construct(
        Aspect $aspect,
        AspectData $aspectData,
        Assessment $assessment,
        AssessmentData $assessmentData
    ) {
        $this->aspect = $aspect;
        $this->aspectData = $aspectData;
        $this->assessment = $assessment;
        $this->assessmentData = $assessmentData;
    }

    public function assessment_aspect(Request $request)
    {
        if ($request->ajax()) {
            return $this->aspectData->getAspectDataTable($request);
        }

        return view('admin.agenda.assessment-aspect.aspect');
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
        $data['siswas'] = Siswa::with('user')->has('user')->get();
        $data['periodes'] = Periode::select(['id', 'tahun_ajaran', 'semester'])
            ->orderBy('tahun_ajaran', 'asc')
            ->orderBy('semester', 'asc')
            ->get();

        // dd($data['siswas'][0]->user);

        return view('admin.agenda.assessment-history.history', $data);
    }

    public function get_history(Request $request)
    {
        if ($request->ajax()) {
            $requestAjax = json_decode($request->a, true);

            return $this->assessmentData->getDataTable($requestAjax);
        }
    }

    public function get_note(Request $request)
    {
        $requestNote = json_decode($request->a, true);
        $note = $this->assessment->getNoteAssessment($requestNote);
        if ($note) {
            return response()->json([
                'success' => true,
                'note' => $note->answer,
                'evaluator' => $note->evaluator,
            ]);
        }
    }
}
