<?php

namespace App\Http\Controllers\Guru\Agenda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssessmentGuruController extends Controller
{
    /**
     * method teacher assessment
     */
    public function teacher_assessment()
    {
        return view('guru.agenda.teacher-assessment.teacher');
    }

    /**
     * method history assessment
     */
    public function assessment_history()
    {
        return view('guru.agenda.assessment-history.history');
    }
}
