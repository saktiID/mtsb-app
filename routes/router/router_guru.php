<?php

use App\Http\Controllers\Guru\Agenda\AssessmentGuruController;
use App\Http\Controllers\Guru\Beranda\BerandaGuruController;
use Illuminate\Support\Facades\Route;

Route::prefix('guru')->group(function () {
    Route::get('/beranda', [BerandaGuruController::class, 'index'])->name('beranda-guru');

    Route::prefix('agenda')->group(function () {
        Route::get('/', function () {
            return redirect()->route('beranda-admin');
        });
        Route::get('teacher-assessment', [AssessmentGuruController::class, 'teacher_assessment'])->name('teacher-assessment');
        Route::post('teacher-assessment-store', [AssessmentGuruController::class, 'assessment_store'])->name('teacher-assessment-store');
        Route::get('assessment-history', [AssessmentGuruController::class, 'assessment_history'])->name('assessment-history.guru');
        Route::get('get-teacher-assessment-history', [AssessmentGuruController::class, 'get_history'])->name('get-assessment-history.guru');
        Route::get('get-teacher-note-history', [AssessmentGuruController::class, 'get_note'])->name('get-note-history.guru');
    });
});
