<?php

namespace App\Http\Controllers;

use App\Models\Data\Periode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $periodeAktif;

    public function __construct()
    {
        $this->periodeAktif = Periode::where('periode_status', true)->first();
    }
}
