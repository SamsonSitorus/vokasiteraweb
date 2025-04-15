<?php

use App\Http\Controllers\Artefak_Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen_RoleController;
use App\Http\Controllers\Kelompok_Controller;

use App\Http\Controllers\TugasController;

use App\Http\Controllers\ManajemenroleController;
use App\Http\Controllers\Kelompok_mahasiswa_Controller;


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
        ->name('dashboard.pembimbing')->middleware('dosen_roles:3,5');

    Route::get('/dashboard/penguji', fn () => view('pages.penguji.dashboard'))
        ->name('dashboard.penguji')->middleware('dosen_roles:2,4');

    Route::get('/dashboard/koordinator', fn () => view('pages.koordinator.dashboard'))
        ->name('dashboard.koordinator')->middleware('dosen_roles:1');

    Route::get('/dashboard/BAAK', fn () => view('pages.BAAK.dashboard'))
        ->name('dashboard.BAAK')->middleware('role:Staff');
});


// Manajemen Role
Route::prefix('manajemen role')->group(function () {
    Route::get('/', [ManajemenroleController::class, 'index'])->name('manajemen-role.index');
    Route::get('/create', [ManajemenroleController::class, 'create'])->name('manajemen-role.create');
    Route::post('/', [ManajemenroleController::class, 'store'])->name('manajemen-role.store');
    Route::get('/{id}', [ManajemenroleController::class, 'edit'])->name('manajemen-role.edit');
    Route::put('/{id}', [ManajemenroleController::class, 'update'])->name('manajemen-role.update');
    Route::delete('/{id}', [ManajemenroleController::class, 'destroy'])->name('manajemen-role.destroy');
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
// Kelompok Mahasiswa routes (Controller)
Route::prefix('kelompokMahasiswa')->group(function () {
    Route::get('/kelompok/{id}', [Kelompok_mahasiswa_Controller::class, 'index'])->name('kelompokMahasiswa.index');
    Route::get('/kelompok/create/{id}', [Kelompok_mahasiswa_Controller::class, 'create'])->name('kelompokMahasiswa.create');
    Route::post('/', [Kelompok_mahasiswa_Controller::class, 'store'])->name('kelompokMahasiswa.store');
    Route::get('/{id}', [Kelompok_mahasiswa_Controller::class, 'edit'])->name('kelompokMahasiswa.edit');
    Route::put('/{id}', [Kelompok_mahasiswa_Controller::class, 'update'])->name('kelompokMahasiswa.update');
    Route::delete('/{id}', [Kelompok_mahasiswa_Controller::class, 'destroy'])->name('kelompokMahasiswa.destroy');
});



// Route tugas
Route::prefix('tugas')->group(function(){
    Route::get('/',[TugasController::class, 'index'])->name('tugas.index');
    Route::get('/create', [TugasController::class, 'create'])->name('tugas.create');
    Route::post('/', [TugasController::class, 'store'])->name('tugas.store');
    Route::get('/{id}', [TugasController::class, 'edit'])->name('tugas.edit');
    Route::put('/{id}', [TugasController::class, 'update'])->name('tugas.update');
    Route::delete('/{id}',[TugasController::class, 'destroy'])->name('tugas.destroy');
    Route::get('/{id}/show',[TugasController::class, 'show'])->name('tugas.show');
});


//Route Mahasiswa
Route::prefix('Artefak')->group(function(){
    Route::get('/',[Artefak_Controller::class, 'index'])->name('Artefak.index');
});