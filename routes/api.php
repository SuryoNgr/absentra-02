<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\LaporanPatroliController;
use App\Http\Controllers\Api\PetugasAuthControllerr;
use App\Http\Controllers\Api\JobController;
use Illuminate\Support\Facades\Route;

Route::prefix('petugas')->group(function () {
    // Login tanpa token
    Route::post('/login', [PetugasAuthControllerr::class, 'login']);

    // ✅ Protected route menggunakan guard petugas
    Route::middleware('auth:petugas')->group(function () {
        // Informasi user login & logout
        Route::get('/me', [PetugasAuthControllerr::class, 'me']);
        Route::post('/logout', [PetugasAuthControllerr::class, 'logout']);

        // ✅ ABSENSI ROUTES
        Route::post('/absensi/checkin', [AbsensiController::class, 'checkin']);
        Route::post('/absensi/checkout', [AbsensiController::class, 'checkout']);
        Route::get('/absensi/hari-ini', [AbsensiController::class, 'riwayatHariIni']);

        // ✅ LAPORAN PATROLI
        Route::post('/laporan-patroli', [LaporanPatroliController::class, 'store']);
        Route::get('/laporan-patroli', [LaporanPatroliController::class, 'index']);

        // ✅ JOB (untuk ambil tugas aktif)
        Route::get('/job-aktif', [JobController::class, 'getActiveJob']);
    });
});
