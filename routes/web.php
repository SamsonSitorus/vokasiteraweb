<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen_RoleController;
use App\Http\Controllers\KoordinatorController;
use App\Http\Controllers\Kelompok_Controller;

// Default redirect ke login
Route::get('/', fn () => redirect()->route('login.form'));

// Login routes
Route::get('/login', fn () => view('login'))->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route dengan middleware auth + role
Route::middleware(['auth.api'])->group(function () {
    Route::get('/dashboard/mahasiswa', fn () => view('pages.mahasiswa.dashboard'))
        ->name('dashboard.mahasiswa')->middleware('role:Mahasiswa');

    Route::get('/dashboard/pembimbing', fn () => view('pages.pembimbing.dashboard'))
        ->name('dashboard.pembimbing')->middleware('dosen_roles:2,4');

    Route::get('/dashboard/penguji', fn () => view('pages.penguji.dashboard'))
        ->name('dashboard.penguji')->middleware('dosen_roles:3,5');

    Route::get('/dashboard/koordinator', fn () => view('pages.koordinator.dashboard'))
        ->name('dashboard.koordinator')->middleware('dosen_roles:1');

    Route::get('/dashboard/BAAK', fn () => view('pages.BAAK.dashboard'))
        ->name('dashboard.BAAK')->middleware('role:Staff');
});

// Koordinator routes
Route::prefix('koordinator')->group(function () {
    Route::get('/', [KoordinatorController::class, 'index'])->name('koordinator.index');
    Route::get('/create', [KoordinatorController::class, 'create'])->name('koordinator.create');
    Route::post('/', [KoordinatorController::class, 'store'])->name('koordinator.store');
    Route::get('/{id}', [KoordinatorController::class, 'edit'])->name('koordinator.edit');
    Route::put('/{id}', [KoordinatorController::class, 'update'])->name('koordinator.update');
    Route::delete('/{id}', [KoordinatorController::class, 'destroy'])->name('koordinator.destroy');
});

// Kelompok routes (Controller)
Route::prefix('kelompok')->group(function () {
    Route::get('/', [Kelompok_Controller::class, 'index'])->name('kelompok.index');
    Route::get('/create', [Kelompok_Controller::class, 'create'])->name('kelompok.create');
    Route::post('/', [Kelompok_Controller::class, 'store'])->name('kelompok.store');
    Route::get('/{id}', [Kelompok_Controller::class, 'edit'])->name('kelompok.edit');
    Route::put('/{id}', [Kelompok_Controller::class, 'update'])->name('kelompok.update');
    Route::delete('/{id}', [Kelompok_Controller::class, 'destroy'])->name('kelompok.destroy');
});

// Tugas by koordinator
Route::prefix('tugas')->group(function () {
    Route::get('/', fn () => view('pages.Kordinator.tugas.index'))->name('tugas.index');
    Route::get('/create', fn () => view('pages.kordinator.tugas.create'));
    Route::get('/edit', fn () => view('pages.kordinator.tugas.edit'));
    Route::get('/show', fn () => view('pages.kordinator.tugas.show'));
});

// Kelompok by koordinator
Route::prefix('kelompok')->group(function () {
    Route::get('/', fn () => view('pages.Kordinator.kelompok.index'))->name('kelompok.index.view');
    Route::get('/create', fn () => view('pages.kordinator.kelompok.create'));
    Route::get('/edit', fn () => view('pages.kordinator.kelompok.edit'));
    Route::get('/show', fn () => view('pages.kordinator.kelompok.show'));
});

// Pembimbing by koordinator
Route::prefix('Pembimbing')->group(function () {
    Route::get('/', fn () => view('pages.Kordinator.pembimbing.index'))->name('pembimbing.index');
    Route::get('/create', fn () => view('pages.kordinator.pembimbing.create'));
    Route::get('/edit', fn () => view('pages.kordinator.pembimbing.edit'));
    Route::get('/show', fn () => view('pages.kordinator.pembimbing.show'));
});