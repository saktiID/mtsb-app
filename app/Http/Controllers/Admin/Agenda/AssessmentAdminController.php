<?php

namespace App\Http\Controllers\Admin\Agenda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssessmentAdminController extends Controller
{
    public function assessment_aspect()
    {
        return view('admin.agenda.assessment-aspect.aspect');
    }

    public function assessment_history()
    {
        return view('admin.agenda.assessment-history.history');
    }
}
