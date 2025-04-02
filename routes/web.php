<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
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

    Route::get('/dashboard/dosen', function () {
        return view('pages.kordinator.dashboard');
    })->name('dashboard.dosen')->middleware('role:Dosen');

    Route::get('/dashboard/BAAK', function () {
        return view('pages.BAAK.dashboard');
    })->name('dashboard.BAAK')->middleware('role:Staff');
});


//
Route::get('/kordinator',function() {
    return view('pages.BAAK.kordinator.index');
})->name('kordinator.index');



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
