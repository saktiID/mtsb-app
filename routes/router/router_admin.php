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

        Route::prefix('data-guru')->group(function () {
            Route::get('/', [DataGuruController::class, 'index'])->name('data-guru');
            Route::get('{id}', [DataGuruController::class, 'detail_guru'])->name('detail-data-guru');
            Route::post('/', [DataGuruController::class, 'tambah_guru'])->name('tambah-data-guru');
            Route::post('update', [DataGuruController::class, 'update_guru'])->name('update-data-guru');
            Route::post('hapus', [DataGuruController::class, 'hapus_guru'])->name('hapus-data-guru');
        });

        Route::prefix('data-siswa')->group(function () {
            Route::get('/', [DataSiswaController::class, 'index'])->name('data-siswa');
            Route::get('{id}', [DataSiswaController::class, 'detail_siswa'])->name('detail-data-siswa');
            Route::post('/', [DataSiswaController::class, 'tambah_siswa'])->name('tambah-data-siswa');
            Route::post('update', [DataSiswaController::class, 'update_siswa'])->name('update-data-siswa');
            Route::post('hapus', [DataSiswaController::class, 'hapus_siswa'])->name('hapus-data-siswa');
        });

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
