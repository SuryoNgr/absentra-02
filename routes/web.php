<?php

use App\Http\Controllers\Api\AbsensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;


Route::get('/storage/{filename}', function ($filename) {
    $path = storage_path('app/public/foto-patroli/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
})->where('filename', '.*')->name('foto.patroli');
// Root
Route::get('/', fn() => redirect()->route('login'));

// ===========================
// AUTH ROUTES
// ===========================
Route::middleware(['guest', 'prevent-back-history'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'verify'])->name('auth.verify');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    



// ===========================
// ADMIN ROUTES
// ===========================
Route::middleware(['auth:admin', 'prevent-back-history'])->group(function () {
    Route::get('/admin/home', [\App\Http\Controllers\admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Data Client
    Route::prefix('/admin/clients')->name('admin.client.')->group(function () {
        Route::get('/', [\App\Http\Controllers\admin\ClientController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\admin\ClientController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\admin\ClientController::class, 'store'])->name('store');
        Route::get('/{client}/edit', [\App\Http\Controllers\admin\ClientController::class, 'edit'])->name('edit');
        Route::put('/{client}', [\App\Http\Controllers\admin\ClientController::class, 'update'])->name('update');
        Route::delete('/{client}', [\App\Http\Controllers\admin\ClientController::class, 'destroy'])->name('destroy');
        Route::get('/bulk-upload', [\App\Http\Controllers\admin\ClientController::class, 'bulkUpload'])->name('bulk_upload');
        Route::post('/import', [\App\Http\Controllers\admin\ClientController::class, 'import'])->name('import');
        Route::get('/template', [\App\Http\Controllers\admin\ClientController::class, 'downloadTemplate'])->name('template');
    });

    // Supervisor
    Route::prefix('/admin/supervisor')->name('admin.supervisor.')->group(function () {
        Route::get('/', [\App\Http\Controllers\admin\SupervisorController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\admin\SupervisorController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\admin\SupervisorController::class, 'store'])->name('store');
        Route::post('/{id}/reset-password', [\App\Http\Controllers\admin\SupervisorController::class, 'resetPassword'])->name('reset-password');
    });

    // Petugas
    Route::prefix('/admin/petugas')->name('admin.petugas.')->group(function () {
        Route::get('/', [\App\Http\Controllers\admin\PetugasController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\admin\PetugasController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\admin\PetugasController::class, 'store'])->name('store');
        Route::get('/{petugas}/edit', [\App\Http\Controllers\admin\PetugasController::class, 'edit'])->name('edit');
        Route::put('/{petugas}', [\App\Http\Controllers\admin\PetugasController::class, 'update'])->name('update');
        Route::delete('/{petugas}', [\App\Http\Controllers\admin\PetugasController::class, 'destroy'])->name('destroy');
        Route::get('/bulk-upload', [\App\Http\Controllers\admin\PetugasController::class, 'bulkUpload'])->name('bulk_upload');
        Route::post('/import', [\App\Http\Controllers\admin\PetugasController::class, 'import'])->name('import');
        Route::get('/template', [\App\Http\Controllers\admin\PetugasController::class, 'downloadTemplate'])->name('template');
        Route::post('/supervisor/{id}/reset-password', [\App\Http\Controllers\admin\SupervisorController::class, 'resetPassword'])->name('admin.supervisor.reset-password');
        Route::get('/role/{role}', [\App\Http\Controllers\admin\PetugasController::class, 'indexByRole'])->name('by_role');
    });

    // Manage Petugas
    Route::prefix('/admin/manage-petugas')->name('admin.manage-petugas.')->group(function () {
        Route::get('/', [\App\Http\Controllers\admin\ManagePetugasController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\admin\ManagePetugasController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\admin\ManagePetugasController::class, 'store'])->name('store');
        Route::get('/{petugas}/edit', [\App\Http\Controllers\admin\ManagePetugasController::class, 'edit'])->name('edit');
        Route::put('/{petugas}', [\App\Http\Controllers\admin\ManagePetugasController::class, 'update'])->name('update');
        Route::get('/petugas-by-role/{role}', [\App\Http\Controllers\admin\ManagePetugasController::class, 'getPetugasByRole']);
        Route::get('/bulk-upload', [\App\Http\Controllers\admin\ManagePetugasController::class, 'bulkUpload'])->name('bulk_upload');
        Route::post('/import', [\App\Http\Controllers\admin\ManagePetugasController::class, 'import'])->name('import');
    });

    // Info akun admin
    Route::get('/admin/data-admin', [\App\Http\Controllers\AdminDataController::class, 'dataAdmin'])->name('admin.data_admin');
    Route::get('/absensi/', [\App\Http\Controllers\admin\AbsensiController::class, 'index'])->name('admin.absensi.index');
});

// ===========================
// CLIENT ROUTES
// ===========================
Route::middleware(['auth:client', 'prevent-back-history'])->group(function () {
    Route::get('/client/home', [\App\Http\Controllers\client\DashboardController::class, 'index'])->name('client.dashboard');
});

// ===========================
// SUPERVISOR ROUTES
// ===========================
Route::middleware(['auth:supervisor', 'prevent-back-history'])->group(function () {
    Route::get('/supervisor/home', [\App\Http\Controllers\supervisor\DashboardController::class, 'index'])->name('supervisor.dashboard');

    Route::get('/supervisor/petugas', [\App\Http\Controllers\supervisor\PetugasController::class, 'index'])->name('supervisor.petugas.index');
    Route::put('/supervisor/petugas/{id}/unassign', [\App\Http\Controllers\supervisor\PetugasController::class, 'unassign'])->name('supervisor.petugas.unassign');
    Route::get('/riwayat-absensi', [\App\Http\Controllers\supervisor\AbsensiController::class, 'index'])->name('supervisor.absensi.index');
    Route::get('/riwayat-absensi/rekap', [\App\Http\Controllers\supervisor\AbsensiController::class, 'rekapPdf'])->name('supervisor.absensi.rekap');
    Route::get('aktivitas/', [\App\Http\Controllers\supervisor\AktivitasController::class, 'index'])->name('supervisor.aktivitas.index');
    Route::get('/aktivitas/cetak', [\App\Http\Controllers\supervisor\AktivitasController::class, 'cetak'])->name('supervisor.aktivitas.cetak');
    // Job Cleaning
    Route::prefix('supervisor/job')->name('supervisor.job.')->group(function () {
        Route::get('/cleaning', [\App\Http\Controllers\supervisor\CleaningJobController::class, 'index'])->name('cleaning.index');
        Route::get('/cleaning/create', [\App\Http\Controllers\supervisor\CleaningJobController::class, 'create'])->name('cleaning.create');
        Route::post('/cleaning', [\App\Http\Controllers\supervisor\CleaningJobController::class, 'store'])->name('cleaning.store');
        Route::get('/cleaning/{job}', [\App\Http\Controllers\supervisor\CleaningJobController::class, 'show'])->name('cleaning.show');
        Route::get('/cleaning/{job}/edit', [\App\Http\Controllers\supervisor\CleaningJobController::class, 'edit'])->name('cleaning.edit');
        Route::put('/cleaning/{job}', [\App\Http\Controllers\supervisor\CleaningJobController::class, 'update'])->name('cleaning.update');
        Route::get('/cleaning/disband/{team}', [\App\Http\Controllers\supervisor\CleaningJobController::class, 'disbandTeam'])->name('cleaning.disbandTeam');
    });

    // Job Security
    Route::prefix('supervisor/job/security')->name('supervisor.job.security.')->group(function () {
        Route::get('/', [\App\Http\Controllers\supervisor\SecurityJobController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\supervisor\SecurityJobController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\supervisor\SecurityJobController::class, 'store'])->name('store');
        Route::get('/{job}', [\App\Http\Controllers\supervisor\SecurityJobController::class, 'show'])->name('show');
        Route::get('/{job}/edit', [\App\Http\Controllers\supervisor\SecurityJobController::class, 'edit'])->name('edit');
        Route::put('/{job}/update', [\App\Http\Controllers\supervisor\SecurityJobController::class, 'update'])->name('update');
        Route::get('/disband/{team}', [\App\Http\Controllers\supervisor\SecurityJobController::class, 'disbandTeam'])->name('disbandTeam');
    });



    // Ganti Password saat login pertama
    Route::get('/supervisor/force-password-change', [\App\Http\Controllers\supervisor\PasswordController::class, 'showChangeForm'])->name('supervisor.password.change');
    Route::post('/supervisor/force-password-change', [\App\Http\Controllers\supervisor\PasswordController::class, 'update'])->name('supervisor.password.update');
});
