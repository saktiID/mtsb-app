<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataKelasController extends Controller
{
    public function index()
    {
        return view('admin.data.kelas.data-kelas');
    }
}
