<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guru\Beranda\BerandaGuruController;
use App\Http\Controllers\Guru\Agenda\AssessmentGuruController;

Route::prefix('guru')->group(function () {
    Route::get('/beranda', [BerandaGuruController::class, 'index'])->name('beranda-guru');

    Route::prefix('agenda')->group(function () {
        Route::get('/', function () {
            return redirect()->route('beranda-admin');
        });
        Route::get('teacher-assessment', [AssessmentGuruController::class, 'teacher_assessment'])->name('teacher-assessment');
        Route::get('assessment-history', [AssessmentGuruController::class, 'assessment_history'])->name('assessment-history.guru');
    });
});
