<?php

namespace App\Services;

use App\Models\Data\Kelas;
use App\Models\Data\Periode;
use Illuminate\Support\Facades\Auth;

class MenuService
{
    private $periodeAktif;

    public function __construct()
    {
        $this->periodeAktif = Periode::where('periode_status', true)->select('id')->first();
    }

    public function getMenuAgenda()
    {
        if (Auth::check()) {
            $menuAgenda = null;
            if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Guru') {
                $agenda = Kelas::where('periode_id', $this->periodeAktif->id)
                    ->where('walas_id', Auth::user()->id)
                    ->first();

                if ($agenda) {
                    $menuAgenda = $agenda;

                    return $menuAgenda;
                } else {
                    return $menuAgenda;
                }
            } else {
                return $menuAgenda;
            }
        }
    }
}
