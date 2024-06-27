<?php

namespace App\Http\Controllers\Siswa\Agenda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssessmentSiswaController extends Controller
{
    public function parent_assessment()
    {
        return view('siswa.agenda.parent-assessment.parent');
    }

    public function peer_assessment()
    {
        return view('siswa.agenda.peer-assessment.peer');
    }

    public function assessment_history()
    {
        return view('siswa.agenda.assessment-history.history');
    }
}
