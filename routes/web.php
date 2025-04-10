<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen_RoleController;
use App\Http\Controllers\KoordinatorController;
use App\Http\Controllers\Kelompok_Controller;
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

        Route::get('/dashboard/pembimbing', function () {
            return view('pages.pembimbing.dashboard');
        })->name('dashboard.pembimbing')->middleware('dosen_roles:2,4');
    
        Route::get('/dashboard/penguji', function () {
            return view('pages.penguji.dashboard');
        })->name('dashboard.penguji')->middleware('dosen_roles:3,5');

        Route::get('/dashboard/koordinator', function () {
            return view('pages.koordinator.dashboard');
        })->name('dashboard.koordinator')->middleware('dosen_roles:1');

        Route::get('/dashboard/BAAK', function () {
            return view('pages.BAAK.dashboard');
        })->name('dashboard.BAAK')->middleware('role:Staff');
});

Route::get('/koordinator',[KoordinatorController::class, 'index'])->name('koordinator.index');
Route::get('/koordinator/create',[KoordinatorController::class, 'create'])->name('koordinator.create');
Route::post('/koordinator',[KoordinatorController::class, 'store'])->name('koordinator.store');
Route::delete('/koordinator/{id}',[KoordinatorController::class, 'destroy'])->name('koordinator.destroy');
Route::get('/koordinator/{id}',[KoordinatorController::class, 'edit'])->name('koordinator.edit');
Route::put('/koordinator/{id}',[KoordinatorController::class, 'update'])->name('koordinator.update');

Route::get('/kelompok',[Kelompok_Controller::class, 'index'])->name('koordinator.index');
Route::get('/kelompok/create',[Kelompok_Controller::class, 'create'])->name('koordinator.create');
Route::post('/kelompok',[Kelompok_Controller::class, 'store'])->name('kelompok.store');
Route::delete('/kelompok/{id}',[Kelompok_Controller::class, 'destroy'])->name('kelompok.destroy');
Route::get('/kelompok/{id}',[Kelompok_Controller::class, 'edit'])->name('kelompok.edit');
Route::put('/kelompok/{id}',[Kelompok_Controller::class, 'update'])->name('kelompok.update');





Route::get('/tugas', function () {
    return view('pages/  
    /tugas.index'); // Menampilkan halaman tugas/index.blade.php
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
