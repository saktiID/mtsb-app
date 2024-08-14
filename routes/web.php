<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FotoGetterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrintAssessmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PushSubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('attempt_login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('update-profile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/get-foto/{filename}', [FotoGetterController::class, 'foto'])->name('get-foto');
    Route::post('/upload-foto', [FotoGetterController::class, 'upload_foto'])->name('foto-profile');
    Route::post('/print-assessment', [PrintAssessmentController::class, 'print_assessment'])->name('print-assessment');

    Route::group(['middleware' => ['role']], function () {
        include 'router/router_admin.php';
        include 'router/router_guru.php';
        include 'router/router_siswa.php';
    });
});

Route::post('push-subscribe', [PushSubscriptionController::class, 'store'])->name('push-subscribe');
Route::get('send-notif', [PushSubscriptionController::class, 'send'])->name('send');
