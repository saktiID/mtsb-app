<?php

use App\Http\Controllers\Admin\Agenda\AssessmentAdminController;
use App\Http\Controllers\Admin\Beranda\BerandaAdminController;
use App\Http\Controllers\Admin\Data\DataGuruController;
use App\Http\Controllers\Admin\Data\DataKelasController;
use App\Http\Controllers\Admin\Data\DataPeriodeController;
use App\Http\Controllers\Admin\Data\DataSiswaController;
use App\Http\Controllers\Admin\Data\DataTerhapusController;
use App\Http\Controllers\Admin\OptimasiController;
use Illuminate\Support\Facades\Route;

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
            Route::get('download-template', [DataSiswaController::class, 'download_template'])->name('download-template');
            Route::post('upload-template', [DataSiswaController::class, 'upload_template'])->name('upload-template');
            Route::get('{id}', [DataSiswaController::class, 'detail_siswa'])->name('detail-data-siswa');
            Route::post('/', [DataSiswaController::class, 'tambah_siswa'])->name('tambah-data-siswa');
            Route::post('update', [DataSiswaController::class, 'update_siswa'])->name('update-data-siswa');
            Route::post('hapus', [DataSiswaController::class, 'hapus_siswa'])->name('hapus-data-siswa');
        });

        Route::prefix('data-kelas')->group(function () {
            Route::get('/', [DataKelasController::class, 'index'])->name('data-kelas');
            Route::get('siswakelas', [DataKelasController::class, 'siswa_kelas'])->name('siswa-kelas');
            Route::get('semuasiswa', [DataKelasController::class, 'semua_siswa'])->name('semua-siswa');
            Route::get('{id}', [DataKelasController::class, 'detail_kelas'])->name('detail-kelas');
            Route::post('/', [DataKelasController::class, 'tambah_kelas'])->name('tambah-data-kelas');
            Route::post('hapus', [DataKelasController::class, 'hapus_kelas'])->name('hapus-data-kelas');
            Route::post('set', [DataKelasController::class, 'set_walas'])->name('set-wali-kelas');
            Route::post('masukkan', [DataKelasController::class, 'masukkan_siswa'])->name('masukkan-siswa');
            Route::post('keluarkan', [DataKelasController::class, 'keluarkan_siswa'])->name('keluarkan-siswa');
        });

        Route::prefix('data-periode')->group(function () {
            Route::get('/', [DataPeriodeController::class, 'index'])->name('data-periode');
            Route::post('/', [DataPeriodeController::class, 'tambah_periode'])->name('tambah-data-periode');
            Route::get('hapus/{id}', [DataPeriodeController::class, 'hapus_periode'])->name('hapus-periode');
            Route::post('activate', [DataPeriodeController::class, 'activate_periode'])->name('activate-periode');
        });

        Route::prefix('data-terhapus')->group(function () {
            Route::get('/', [DataTerhapusController::class, 'index'])->name('data-terhapus');
            Route::post('hapus-permanen', [DataTerhapusController::class, 'hapus_permanent_data'])->name('hapus-permanen');
            Route::post('pulihkan-data', [DataTerhapusController::class, 'pulihkan_data'])->name('pulihkan-data');
        });
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
        Route::get('assessment-recap', [AssessmentAdminController::class, 'assessment_recap'])->name('assessment-recap.admin');
        Route::get('get-admin-assessment-history', [AssessmentAdminController::class, 'get_history'])->name('get-assessment-history.admin');
        Route::get('get-admin-note-history', [AssessmentAdminController::class, 'get_note'])->name('get-note-history.admin');
    });

    Route::get('optimasi', [OptimasiController::class, 'index'])->name('optimasi');
    Route::post('view-cache', [OptimasiController::class, 'view_cache'])->name('view-cache');
    Route::post('hapus-view-cache', [OptimasiController::class, 'hapus_view_cache'])->name('hapus-view-cache');
    Route::post('hapus-data-cache', [OptimasiController::class, 'hapus_data_cache'])->name('hapus-data-cache');
    Route::post('hapus-data-session', [OptimasiController::class, 'hapus_data_session'])->name('hapus-data-session');
    Route::post('config-cache', [OptimasiController::class, 'config_cache'])->name('config-cache');
    Route::post('hapus-config-cache', [OptimasiController::class, 'hapus_config_cache'])->name('hapus-config-cache');
});
