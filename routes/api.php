<?php

use App\Http\Controllers\API\DataAPIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('data-kelas', [DataAPIController::class, 'getKelas']);
Route::get('data-siswa', [DataAPIController::class, 'getSiswa']);
Route::get('data-guru', [DataAPIController::class, 'getGuru']);
