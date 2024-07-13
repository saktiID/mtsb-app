<?php

namespace App\Http\Controllers\Siswa\Beranda;

use App\Http\Controllers\Controller;

class BerandaSiswaController extends Controller
{
    public function index()
    {
        return view('siswa.beranda.beranda-siswa');
    }
}
