<?php

namespace App\Services\Agenda;

use App\Models\Agenda\AssessmentAspect;

class AspectService
{
    /**
     * @var array
     * service tambah aspect
     */
    public function tambahAspect($request)
    {
        $aspect = new AssessmentAspect;
        $aspect->aspect = $request->aspect;
        $aspect->aspect_for = $request->aspect_for;
        $query = $aspect->save();
        return $query;
    }

    /**
     * service switch aspect status
     * @var array
     */
    public function switchAspectStatus($id)
    {
        $aspect = AssessmentAspect::find($id);
        $aspect->aspect_status = !$aspect->aspect_status;
        $query = $aspect->save();
        return $query;
    }

    /**
     * service hapus aspect
     * @var array
     */
    public function hapusAspect($id)
    {
        $aspect = AssessmentAspect::find($id);
        $query = $aspect->delete();
        return $query;
    }
}
