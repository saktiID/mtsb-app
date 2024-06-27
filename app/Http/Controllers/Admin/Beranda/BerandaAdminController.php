<?php

namespace App\Http\Controllers\Admin\Beranda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaAdminController extends Controller
{
    public function index()
    {
        return view('admin.beranda.beranda-admin');
    }
}
