<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\Beranda\BerandaSiswaController;
use App\Http\Controllers\Siswa\Agenda\AssessmentSiswaController;


Route::prefix('siswa')->group(function () {
    Route::get('/beranda', [BerandaSiswaController::class, 'index'])->name('beranda-siswa');

    Route::prefix('agenda')->group(function () {
        Route::get('/', function () {
            return redirect()->route('beranda-siswa');
        });
        Route::get('parent-assessment', [AssessmentSiswaController::class, 'parent_assessment'])->name('parent-assessment');
        Route::get('peer-assessment', [AssessmentSiswaController::class, 'peer_assessment'])->name('peer-assessment');
        Route::get('assessment-history', [AssessmentSiswaController::class, 'assessment_history'])->name('assessment-history.siswa');
    });
});
