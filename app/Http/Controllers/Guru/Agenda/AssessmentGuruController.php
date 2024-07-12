<?php

namespace App\Http\Controllers\Guru\Agenda;

use App\Models\Data\Kelas;
use Illuminate\Http\Request;
use App\Models\Data\KelasSiswa;
use App\Http\Controllers\Controller;
use App\Models\Agenda\AssessmentAspect;
use Illuminate\Support\Facades\Auth;

class AssessmentGuruController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function teacher_assessment(Request $request)
    {
        // parameters
        $periode_id = $this->periodeAktif->id;
        $walas_id = Auth::user()->id;
        $kelas = Kelas::where('periode_id', $periode_id)
            ->where('walas_id', $walas_id)->first();

        // data untuk dikirim ke view
        $data['siswaDalamKelas'] = KelasSiswa::with(['user', 'siswa'])
            ->where('kelas_id', $kelas->id)
            ->get();
        $data['kelas'] = $kelas->jenjang_kelas . '-' . $kelas->bagian_kelas;
        $data['periodeAktif'] = $this->periodeAktif;
        $data['aspects'] = AssessmentAspect::where('aspect_for', 'teacher')->get();

        return view('guru.agenda.teacher-assessment.teacher', $data);
    }

    public function assessment_history()
    {
        return view('guru.agenda.assessment-history.history');
    }
}
