<?php

namespace App\Http\Controllers\Admin\Beranda;

use App\Http\Controllers\Controller;

class BerandaAdminController extends Controller
{
    public function index()
    {
        $data['periodeAktif'] = $this->periodeAktif;

        return view('admin.beranda.beranda-admin', $data);
    }
}
