<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * method index home
     */
    public function index()
    {
        if (Auth::user()->role == 'Admin') {
            return redirect()->route('beranda-admin');
        }
        if (Auth::user()->role == 'Guru') {
            return redirect()->route('beranda-guru');
        }
        if (Auth::user()->role == 'Siswa') {
            return redirect()->route('beranda-siswa');
        }
    }
}
