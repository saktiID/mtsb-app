<?php

namespace App\Http\Controllers\Guru\Agenda;

use App\Http\Controllers\Controller;
use App\Models\Agenda\AssessmentAspect;
use App\Models\Data\Kelas;
use App\Models\Data\KelasSiswa;
use App\Services\Agenda\AssessmentDataTableService as AssessmentData;
use App\Services\Agenda\AssessmentService as Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentGuruController extends Controller
{
    private $assessment;

    private $assessmentData;

    public function __construct(Assessment $assessment, AssessmentData $assessmentData)
    {
        parent::__construct();
        $this->assessment = $assessment;
        $this->assessmentData = $assessmentData;
    }

    public function teacher_assessment()
    {
        // parameters
        $periode_id = $this->periodeAktif->id;
        $walas_id = Auth::user()->id;
        $kelas = Kelas::where('periode_id', $periode_id)
            ->where('walas_id', $walas_id)->first();

        // data untuk dikirim ke view
        $data['siswaDalamKelas'] = KelasSiswa::with(['user', 'siswa'])
            ->where('kelas_id', $kelas->id)
            ->join('users', 'kelas_siswas.user_id', '=', 'users.id')
            ->orderBy('users.nama', 'asc')
            ->get();
        $data['kelas'] = $kelas->jenjang_kelas.'-'.$kelas->bagian_kelas;
        $data['periodeAktif'] = $this->periodeAktif;
        $data['aspects'] = AssessmentAspect::where('aspect_for', 'teacher')
            ->where('aspect_status', true)
            ->orderBy('id', 'asc')
            ->get();

        return view('guru.agenda.teacher-assessment.teacher', $data);
    }

    public function assessment_store(Request $request)
    {
        $check = $this->assessment->checkExist($request, 'Teacher');
        if (! $check) {
            $query = $this->assessment->storeAssessment($request, 'Teacher');
            if ($query) {
                return response()->json(['success' => true, 'message' => 'Assessment berhasil disimpan']);
            } else {
                return response()->json(['success' => false, 'message' => 'Assessment gagal disimpan']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Assessment sudah ada']);
        }
    }

    public function assessment_history()
    {
        // parameters
        $periode_id = $this->periodeAktif->id;
        $walas_id = Auth::user()->id;
        $kelas = Kelas::where('periode_id', $periode_id)
            ->where('walas_id', $walas_id)->first();

        // data untuk dikirim ke view
        $data['siswaDalamKelas'] = KelasSiswa::with(['user', 'siswa'])
            ->where('kelas_id', $kelas->id)
            ->join('users', 'kelas_siswas.user_id', '=', 'users.id')
            ->orderBy('users.nama', 'asc')
            ->get();
        $data['kelas'] = $kelas->jenjang_kelas.'-'.$kelas->bagian_kelas;
        $data['periodeAktif'] = $this->periodeAktif;

        return view('guru.agenda.assessment-history.history', $data);
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
