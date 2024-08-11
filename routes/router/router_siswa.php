<?php

use App\Http\Controllers\Siswa\Agenda\AssessmentSiswaController;
use App\Http\Controllers\Siswa\Beranda\BerandaSiswaController;
use App\Http\Controllers\Siswa\Kelas\KelasKamuController;
use Illuminate\Support\Facades\Route;

Route::prefix('siswa')->group(function () {
    Route::get('/beranda', [BerandaSiswaController::class, 'index'])->name('beranda-siswa');

    Route::get('/kelas-kamu', [KelasKamuController::class, 'index'])->name('kelas-kamu');

    Route::prefix('agenda')->group(function () {
        Route::get('/', function () {
            return redirect()->route('beranda-siswa');
        });
        Route::get('parent-assessment', [AssessmentSiswaController::class, 'parent_assessment'])->name('parent-assessment');
        Route::post('parent-assessment-store', [AssessmentSiswaController::class, 'parent_assessment_store'])->name('parent-assessment-store');
        Route::get('peer-assessment', [AssessmentSiswaController::class, 'peer_assessment'])->name('peer-assessment');
        Route::post('peer-assessment-store', [AssessmentSiswaController::class, 'peer_assessment_store'])->name('peer-assessment-store');
        Route::get('assessment-history', [AssessmentSiswaController::class, 'assessment_history'])->name('assessment-history.siswa');
        Route::get('get-assessment-history', [AssessmentSiswaController::class, 'get_history'])->name('get-assessment-history.siswa');
        Route::get('get-note-history', [AssessmentSiswaController::class, 'get_note'])->name('get-note-history.siswa');
        Route::get('print-assessment-history', [AssessmentSiswaController::class, 'print_data'])->name('print-assessment-history.siswa');
    });
});
