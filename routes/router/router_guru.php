<?php

use App\Http\Controllers\Guru\Agenda\AssessmentGuruController;
use App\Http\Controllers\Guru\Beranda\BerandaGuruController;
use App\Http\Controllers\Guru\Kelas\KelasSayaController;
use Illuminate\Support\Facades\Route;

Route::prefix('guru')->group(function () {
    Route::get('/beranda', [BerandaGuruController::class, 'index'])->name('beranda-guru');

    Route::get('kelas-saya', [KelasSayaController::class, 'index'])->name('kelas-saya');
    Route::get('siswakelassaya', [KelasSayaController::class, 'siswa_kelas'])->name('siswa-kelas-saya');
    Route::get('semuasiswaumum', [KelasSayaController::class, 'semua_siswa'])->name('semua-siswa-umum');
    Route::post('masukkan-siswa-saya', [KelasSayaController::class, 'masukkan_siswa'])->name('masukkan-siswa-saya');
    Route::post('keluarkan-siswa-saya', [KelasSayaController::class, 'keluarkan_siswa'])->name('keluarkan-siswa-saya');

    Route::prefix('agenda')->group(function () {
        Route::get('/', function () {
            return redirect()->route('beranda-admin');
        });
        Route::get('teacher-assessment', [AssessmentGuruController::class, 'teacher_assessment'])->name('teacher-assessment');
        Route::post('teacher-assessment-store', [AssessmentGuruController::class, 'assessment_store'])->name('teacher-assessment-store');
        Route::get('assessment-history', [AssessmentGuruController::class, 'assessment_history'])->name('assessment-history.guru');
        Route::get('get-teacher-assessment-history', [AssessmentGuruController::class, 'get_history'])->name('get-assessment-history.guru');
        Route::get('get-teacher-note-history', [AssessmentGuruController::class, 'get_note'])->name('get-note-history.guru');
        Route::get('print-assessment-history', [AssessmentGuruController::class, 'print_data'])->name('print-assessment-history.guru');
    });
});
