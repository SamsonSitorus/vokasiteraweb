<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen_RoleController;
use App\Http\Controllers\Kelompok_Controller;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\ManajemenroleController;
use App\Http\Controllers\Kelompok_mahasiswa_Controller;
use App\Http\Controllers\PengumumanController;


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
    Route::get('/kelompok-mahasiswa/{id}/edit', [Kelompok_mahasiswa_Controller::class, 'edit'])->name('kelompokMahasiswa.edit');
    Route::put('/kelompok-mahasiswa/{id}', [Kelompok_mahasiswa_Controller::class, 'update'])->name('kelompokMahasiswa.update');
    Route::delete('/kelompok-mahasiswa/{id}', [Kelompok_mahasiswa_Controller::class, 'destroy'])->name('kelompokMahasiswa.destroy');
});



// Route tugas
Route::prefix('tugas')->group(function(){
    Route::get('/',[TugasController::class, 'index'])->name('tugas.tugas');
    Route::get('/create', [TugasController::class, 'create'])->name('tugas.create');
    Route::post('/', [TugasController::class, 'store'])->name('tugas.store');
});

    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman/store', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
}); 

//untuk mahasiswa 
Route::get('/pengumuman/mahasiswa', [PengumumanController::class, 'mahasiswaIndex'])->name('pengumuman.mahasiswa.index');
Route::get('mahasiswa/pengumuman/{id}', [PengumumanController::class, 'showMahasiswa'])->name('pengumuman.showMahasiswa');
//untuk pembimbing

Route::get('/pengumuman/pembimbing', [PengumumanController::class, 'pembimbingIndex'])->name('pembimbing.pengumuman.index');
Route::get('/pengumuman/pembimbing/{id}', [PengumumanController::class, 'showpembimbing'])->name('pembimbing.pengumuman.show');