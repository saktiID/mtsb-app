<?php

namespace App\Http\Controllers\Guru\Beranda;

use App\Http\Controllers\Controller;

class BerandaGuruController extends Controller
{
    public function index()
    {
        return view('guru.beranda.beranda-guru');
    }
}
