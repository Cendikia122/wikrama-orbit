<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\LiveEventController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\AbsensiGdsController;
use App\Http\Controllers\PelanggaranGdsController;
use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────── PUBLIC ROUTES ─────────────────

Route::get('/', function () {
    return view('welcome');
});

// Inisialisasi & Seeding Database (Aman: hanya berjalan jika users masih kosong)
Route::get('/init-db', function () {
    if (\App\Models\User::count() > 0) {
        return redirect('/login')->with('success', 'Database sudah berisi data pengurus! Silakan langsung login.');
    }
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    return redirect('/login')->with('success', 'Database berhasil di-seed (28 akun pengurus siap)! Silakan login.');
});

// Auth
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Organisasi (public)
Route::get('/organisasi',           [OrganisasiController::class, 'index'])->name('organisasi');
Route::get('/organisasi/sekbid/{nomor}', [OrganisasiController::class, 'sekbid'])->name('sekbid.show');

// Aspirasi (list public)
Route::get('/aspirasi', [AspirasiController::class, 'index'])->name('aspirasi.index');

// Live Events (public view)
Route::get('/live-events',       [LiveEventController::class, 'index'])->name('live-events.index');
Route::get('/live-events/{id}',  [LiveEventController::class, 'show'])->name('live-events.show');

// ─────────────────────────────────────────────── AUTH ROUTES ───────────────────

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/change-password',  [AuthController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'updatePassword']);

    // Dashboard / Kegiatan OSIS
    Route::get('/dashboard',  [KegiatanController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [KegiatanController::class, 'store']);
    Route::get('/dashboard/{id}/edit',   [KegiatanController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/dashboard/{id}',        [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::patch('/dashboard/{id}/kanban', [KegiatanController::class, 'updateKanban'])->name('kegiatan.kanban');
    Route::patch('/dashboard/{id}/toggle', [KegiatanController::class, 'toggleStatus'])->name('kegiatan.toggle');
    Route::delete('/dashboard/{id}',     [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    // Aspirasi (submit & manage — requires login)
    Route::post('/aspirasi',           [AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::patch('/aspirasi/{id}',     [AspirasiController::class, 'update'])->name('aspirasi.update');
    Route::delete('/aspirasi/{id}',    [AspirasiController::class, 'destroy'])->name('aspirasi.destroy');

    // Live Events (create & vote — requires login)
    Route::get('/live-events/create',            [LiveEventController::class, 'create'])->name('live-events.create');
    Route::post('/live-events',                  [LiveEventController::class, 'store'])->name('live-events.store');
    Route::post('/live-events/{id}/vote',        [LiveEventController::class, 'vote'])->name('live-events.vote');
    Route::patch('/live-events/{id}/status',     [LiveEventController::class, 'updateStatus'])->name('live-events.status');

    // Piket GDS (auth only)
    Route::get('/piket', [PiketController::class, 'index'])->name('piket.index');
    Route::post('/piket/upload',    [PiketController::class, 'upload'])->name('piket.upload');
    Route::get('/piket/my-schedule', [PiketController::class, 'mySchedule'])->name('piket.mine');

    // GDS Absensi (pengurus only)
    Route::get('/piket/absensi', [AbsensiGdsController::class, 'index'])->name('absensi.index');
    Route::post('/piket/absensi', [AbsensiGdsController::class, 'store'])->name('absensi.store');
    Route::delete('/piket/absensi/{id}', [AbsensiGdsController::class, 'destroy'])->name('absensi.destroy');

    // GDS Pelanggaran (pengurus only) 
    Route::get('/piket/pelanggaran', [PelanggaranGdsController::class, 'index'])->name('pelanggaran.index');
    Route::post('/piket/pelanggaran', [PelanggaranGdsController::class, 'store'])->name('pelanggaran.store');
    Route::delete('/piket/pelanggaran/{id}', [PelanggaranGdsController::class, 'destroy'])->name('pelanggaran.destroy');

    // Monitoring & Manajemen Anggota
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/tambah', [MonitoringController::class, 'create'])->name('monitoring.create');
    Route::post('/monitoring', [MonitoringController::class, 'store'])->name('monitoring.store');
    Route::get('/monitoring/{id}/edit', [MonitoringController::class, 'edit'])->name('monitoring.edit');
    Route::put('/monitoring/{id}', [MonitoringController::class, 'update'])->name('monitoring.update');
    Route::patch('/monitoring/{id}/toggle', [MonitoringController::class, 'toggleAktif'])->name('monitoring.toggle');
    Route::patch('/monitoring/{id}/reset-password', [MonitoringController::class, 'resetPassword'])->name('monitoring.reset-password');
    Route::delete('/monitoring/{id}', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');

    // Keuangan (DH only)
    Route::get('/keuangan',      [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::post('/keuangan',     [KeuanganController::class, 'store'])->name('keuangan.store');
    Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');
});
