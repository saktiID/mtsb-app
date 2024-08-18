<?php

namespace App\Http\Controllers\Siswa\Agenda;

use App\Http\Controllers\Controller;
use App\Models\Agenda\AssessmentAspect;
use App\Models\Data\KelasSiswa;
use App\Models\Data\Periode;
use App\Services\Agenda\AssessmentDataTableService as AssessmentData;
use App\Services\Agenda\AssessmentService as Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AssessmentSiswaController extends Controller
{
    private $assessment;

    private $assessmentData;

    public function __construct(Assessment $assessment, AssessmentData $assessmentData)
    {
        parent::__construct();
        $this->assessment = $assessment;
        $this->assessmentData = $assessmentData;
    }

    private function _checkKelas()
    {
        $kelasSiswa = KelasSiswa::where('periode_id', $this->periodeAktif->id)
            ->where('user_id', Auth::user()->id)->exists();
        if (! $kelasSiswa) {
            abort(404);
        }
    }

    public function parent_assessment()
    {
        $this->_checkKelas();

        $periode_id = $this->periodeAktif->id;
        $kelas = KelasSiswa::with('kelas')
            ->where('periode_id', $periode_id)
            ->where('user_id', Auth::user()->id)->first();

        $data['periodeAktif'] = $this->periodeAktif;
        $data['kelas'] = $kelas;
        $data['aspects'] = Cache::remember('aspect-parent', 300, function () {
            return AssessmentAspect::where('aspect_for', 'parent')
                ->where('aspect_status', true)
                ->orderBy('id', 'asc')
                ->get();
        });

        return view('siswa.agenda.parent-assessment.parent', $data);
    }

    public function peer_assessment()
    {
        $this->_checkKelas();

        $periode_id = $this->periodeAktif->id;
        $kelas = KelasSiswa::with('kelas')
            ->where('periode_id', $periode_id)
            ->where('user_id', Auth::user()->id)->first();

        $data['siswaDalamKelas'] = Cache::remember($kelas->kelas->id, 1200, function () use ($kelas) {
            return KelasSiswa::with(['user:id,avatar,nama', 'siswa:user_id,nis'])
                ->where('kelas_id', $kelas->kelas->id)
                ->join('users', 'kelas_siswas.user_id', '=', 'users.id')
                ->orderBy('users.nama', 'asc')
                ->get();
        });
        $data['periodeAktif'] = $this->periodeAktif;
        $data['kelas'] = $kelas;
        $data['walas_id'] = $kelas->kelas->walas_id;
        $data['aspects'] = Cache::remember('aspcet-peer', 300, function () {
            return AssessmentAspect::where('aspect_for', 'peer')
                ->where('aspect_status', true)
                ->orderBy('id', 'asc')
                ->get();
        });

        return view('siswa.agenda.peer-assessment.peer', $data);
    }

    public function parent_assessment_store(Request $request)
    {
        $check = $this->assessment->checkExist($request, 'Parent');
        if (! $check) {
            $query = $this->assessment->storeAssessment($request, 'Parent');
            if ($query) {
                return response()->json(['success' => true, 'message' => 'Assessment telah masuk antrian untuk disimpan dalam database. Tunggu beberapa saat untuk melihat riwayat.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Assessment gagal disimpan']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Assessment sudah ada']);
        }
    }

    public function peer_assessment_store(Request $request)
    {
        $check = $this->assessment->checkExist($request, 'Peer');
        if (! $check) {
            $query = $this->assessment->storeAssessment($request, 'Peer - '.Auth::user()->nama);
            if ($query) {
                return response()->json(['success' => true, 'message' => 'Assessment telah masuk antrian untuk disimpan dalam database. Tunggu beberapa saat untuk melihat riwayat.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Assessment gagal disimpan']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Assessment sudah ada']);
        }
    }

    public function assessment_history()
    {
        $data['periodes'] = Periode::select(['id', 'tahun_ajaran', 'semester'])
            ->orderBy('tahun_ajaran', 'asc')
            ->orderBy('semester', 'asc')
            ->get();
        $data['periodeAktif'] = $this->periodeAktif;
        $data['kelas'] = KelasSiswa::where('periode_id', $this->periodeAktif->id)
            ->has('kelas')
            ->with('kelas')
            ->where('user_id', Auth::user()->id)->first();

        return view('siswa.agenda.assessment-history.history', $data);
    }

    public function print_data(Request $request)
    {
        return $this->assessment->printAssessment($request);
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
