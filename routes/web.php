<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VariableController;

/*
|--------------------------------------------------------------------------
| Web Routes — SpekTi
|--------------------------------------------------------------------------
*/

// ── Home Redirect ──
Route::get('/', function () {
    return redirect()->route('login');
});

// ── Auth Routes ──
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Mahasiswa Routes ──
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/prescreening', [StudentController::class, 'preScreening'])->name('prescreening');
    Route::post('/prescreening', [StudentController::class, 'prosesPreScreening'])->name('prescreening.proses');
    Route::get('/export-prescreening-pdf', [StudentController::class, 'exportPreScreeningPdf'])->name('export.prescreening.pdf');
    Route::get('/kuesioner', [StudentController::class, 'kuesioner'])->name('kuesioner');
    Route::post('/prediksi', [StudentController::class, 'prosesPrediksi'])->name('prediksi');
    Route::post('/request-edit/{id}', [StudentController::class, 'requestEdit'])->name('request.edit');
    Route::get('/hasil/{id}', [StudentController::class, 'hasil'])->name('hasil');
    Route::get('/riwayat', [StudentController::class, 'riwayat'])->name('riwayat');
    Route::get('/export-pdf/{id}', [StudentController::class, 'exportPdf'])->name('export.pdf');
});

// ── Admin Routes ──
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Analitik
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Revisi Prediksi Mahasiswa
    Route::get('/revisions', [AdminController::class, 'revisionRequests'])->name('revisions.index');
    Route::post('/revisions/{id}/approve', [AdminController::class, 'approveRevision'])->name('revisions.approve');
    Route::post('/revisions/{id}/reject', [AdminController::class, 'rejectRevision'])->name('revisions.reject');

    // Kelola Variabel Penelitian (CRUD)
    Route::get('/variables', [VariableController::class, 'index'])->name('variables.index');
    Route::get('/variables/create', [VariableController::class, 'create'])->name('variables.create');
    Route::post('/variables', [VariableController::class, 'store'])->name('variables.store');
    Route::get('/variables/{id}/edit', [VariableController::class, 'edit'])->name('variables.edit');
    Route::put('/variables/{id}', [VariableController::class, 'update'])->name('variables.update');
    Route::delete('/variables/{id}', [VariableController::class, 'destroy'])->name('variables.destroy');

    // Kelola Rules (CRUD)
    Route::get('/rules', [AdminController::class, 'rulesIndex'])->name('rules.index');
    Route::get('/rules/create', [AdminController::class, 'rulesCreate'])->name('rules.create');
    Route::post('/rules', [AdminController::class, 'rulesStore'])->name('rules.store');
    Route::get('/rules/{id}/edit', [AdminController::class, 'rulesEdit'])->name('rules.edit');
    Route::put('/rules/{id}', [AdminController::class, 'rulesUpdate'])->name('rules.update');
    Route::delete('/rules/{id}', [AdminController::class, 'rulesDestroy'])->name('rules.destroy');

    // Manajemen Data Mahasiswa (full CRUD)
    Route::get('/mahasiswa', [AdminController::class, 'mahasiswaIndex'])->name('mahasiswa.index');
    Route::get('/mahasiswa/create', [AdminController::class, 'mahasiswaCreate'])->name('mahasiswa.create');
    Route::post('/mahasiswa', [AdminController::class, 'mahasiswaStore'])->name('mahasiswa.store');
    Route::get('/mahasiswa/{id}', [AdminController::class, 'mahasiswaDetail'])->name('mahasiswa.detail');
    Route::get('/mahasiswa/{id}/edit', [AdminController::class, 'mahasiswaEdit'])->name('mahasiswa.edit');
    Route::put('/mahasiswa/{id}', [AdminController::class, 'mahasiswaUpdate'])->name('mahasiswa.update');
    Route::delete('/mahasiswa/{id}', [AdminController::class, 'mahasiswaDestroy'])->name('mahasiswa.destroy');
    Route::get('/mahasiswa/{mahasiswaId}/export-pdf/{predictionId}', [AdminController::class, 'exportPdf'])->name('mahasiswa.export.pdf');

    // Export Rekap Prediksi (filter: semua, lulus, tidak-lulus)
    Route::get('/export-rekap/{filter?}', [AdminController::class, 'exportRekap'])->name('export.rekap');

    // Pre-screening Log (mahasiswa ditolak)
    Route::get('/prescreening', [AdminController::class, 'preScreeningIndex'])->name('prescreening');
    Route::get('/prescreening/{userId}/export-pdf', [AdminController::class, 'exportPreScreeningPdf'])->name('prescreening.export.pdf');
});
