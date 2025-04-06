<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen_RoleController;
use App\Http\Controllers\KoordinatorController;
// Halaman login (GET)
Route::get('/login', function () {return view('login');})->name('login.form');
// Proses login (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Logout (POST)
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth.api'])->group(function () {
        Route::get('/dashboard/mahasiswa', function () {
        return view('pages.mahasiswa.dashboard');
        })->name('dashboard.mahasiswa')->middleware('role:Mahasiswa');

        Route::get('/dashboard/pembimbing1', function () {
            return view('pages.pembimbing1.dashboard');
        })->name('dashboard.pembimbing2')->middleware('dosen_roles:1');
    
        Route::get('/dashboard/penguji2', function () {
            return view('pages.penguji2.dashboard');
        })->name('dashboard.penguji2')->middleware('dosen_roles:2');

        Route::get('/dashboard/koordinator', function () {
            return view('pages.koordinator.dashboard');
        })->name('dashboard.koordinator')->middleware('dosen_roles:3');

        Route::get('/dashboard/pembimbing2', function () {
            return view('pages.pembimbing2.dashboard');
        })->name('dashboard.pembimbing2')->middleware('dosen_roles:6');

        Route::get('/dashboard/penguji1', function () {
            return view('pages.penguji1.dashboard');
        })->name('dashboard.penguji1')->middleware('dosen_roles:7');
    
        Route::get('/dashboard/BAAK', function () {
            return view('pages.BAAK.dashboard');
        })->name('dashboard.BAAK')->middleware('role:Staff');
});


Route::get('/koordinator',[KoordinatorController::class, 'create'])->name('koordinator.index');
Route::post('/dosen-role',[Dosen_RoleController::class, 'store'])->name('dosen-role.store');

Route::get('/tugas', function () {
    return view('pages/Kordinator/tugas.index'); // Menampilkan halaman tugas/index.blade.php
})->name('tugas.index');
//untuk tugas by kordinator
Route::get('/tugas', function () {
    return view('pages/Kordinator/tugas.index'); // Menampilkan halaman tugas/index.blade.php
})->name('tugas.index');
Route::get('/tugas/create',function(){
    return view('pages/kordinator/tugas/create');
});
Route::get('/tugas/edit',function(){
    return view('pages/kordinator/tugas/edit');
});
Route::get('/tugas/show',function(){
    return view('pages/kordinator/tugas/show');
});
// untuk kelompok by kordinator
Route::get('/kelompok', function () {
    return view('pages/Kordinator/kelompok.index'); // Menampilkan halaman kelompok/index.blade.php
})->name('kelompok.index');
Route::get('/kelompok/create',function(){
    return view('pages/kordinator/kelompok/create');
});
Route::get('/kelompok/edit',function(){
    return view('pages/kordinator/kelompok/edit');
});
Route::get('/kelompok/show',function(){
    return view('pages/kordinator/kelompok/show');
});

//untuk pembimmbing by kordinator
Route::get('/Pembimbing', function () {
    return view('pages/Kordinator/pembimbing.index'); // Menampilkan halaman pembimbing/index.blade.php
})->name('pembimbing.index');
Route::get('/pembimbing/create',function(){
    return view('pages/kordinator/pembimbing/create');
});
Route::get('/pembimbing/edit',function(){
    return view('pages/kordinator/pembimbing/edit');
});
Route::get('/pembimbing/show',function(){
    return view('pages/kordinator/pembimbing/show');
});
