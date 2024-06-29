<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Data\DataGuruController;
use App\Http\Controllers\Admin\Data\DataKelasController;
use App\Http\Controllers\Admin\Data\DataSiswaController;
use App\Http\Controllers\Admin\Data\DataPeriodeController;
use App\Http\Controllers\Admin\Beranda\BerandaAdminController;
use App\Http\Controllers\Admin\Agenda\AssessmentAdminController;

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('beranda-admin');
    });
    Route::get('/beranda', [BerandaAdminController::class, 'index'])->name('beranda-admin');

    Route::prefix('database')->group(function () {
        Route::get('/', function () {
            return redirect()->route('beranda-admin');
        });
        Route::get('data-siswa', [DataSiswaController::class, 'index'])->name('data-siswa');
        Route::get('data-guru', [DataGuruController::class, 'index'])->name('data-guru');
        Route::get('data-kelas', [DataKelasController::class, 'index'])->name('data-kelas');
        Route::get('data-periode', [DataPeriodeController::class, 'index'])->name('data-periode');
    });

    Route::prefix('agenda')->group(function () {
        Route::get('/', function () {
            return redirect()->route('beranda-admin');
        });
        Route::get('assessment-aspect', [AssessmentAdminController::class, 'assessment_aspect'])->name('assessment-aspect');

        Route::post('tambah-assessment-aspect', [AssessmentAdminController::class, 'tambah_assessment_aspect'])->name('tambah-assessment-aspect');

        Route::post('switch-aspect-status', [AssessmentAdminController::class, 'switch_aspect_status'])->name('switch-aspect-status');

        Route::post('hapus-assessment-aspect', [AssessmentAdminController::class, 'hapus_assessment_aspect'])->name('hapus-assessment-aspect');

        Route::get('assessment-history', [AssessmentAdminController::class, 'assessment_history'])->name('assessment-history.admin');
    });
});
