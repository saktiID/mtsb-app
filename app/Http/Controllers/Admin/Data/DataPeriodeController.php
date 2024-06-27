<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataPeriodeController extends Controller
{
    public function index()
    {
        return view('admin.data.periode.data-periode');
    }
}
