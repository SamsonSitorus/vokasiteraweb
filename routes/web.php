<?php

use App\Http\Controllers\Artefak_Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen_RoleController;
use App\Http\Controllers\Kelompok_Controller;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\ManajemenroleController;
use App\Http\Controllers\Kelompok_mahasiswa_Controller;
use App\Http\Controllers\pembimbing_Controller;
use App\Http\Controllers\Pembimbing_tugas_Controller;
use App\Http\Controllers\pengumpulan_tugasController;
use App\Http\Controllers\PengumumanController;
use App\Models\pengumpulan_tugas;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JadwalMahasiswaController;
use App\Http\Controllers\NilaiKelompok_Controller;
use App\Http\Controllers\NilaiMahasiswa_Controller;
use App\Http\Controllers\Penguji_Controller;
use App\Http\Controllers\penguji_tugas_Controller;
use App\Http\Controllers\TahunAjaran_Controller;
use App\Http\Controllers\TahunMasuk_Controller;
use App\Models\Nilai_kelompok;
use App\Models\Pengumuman;
use App\Http\Controllers\PengajuanSeminarController;


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



// Route tugas olwh koordinator
Route::prefix('tugas')->group(function(){
    //untuk koordinator
    Route::get('/koordinator',[TugasController::class, 'index'])->name('tugas.index');
    Route::get('/create', [TugasController::class, 'create'])->name('tugas.create');
    Route::post('/', [TugasController::class, 'store'])->name('tugas.store');
    Route::get('/{id}', [TugasController::class, 'edit'])->name('tugas.edit');
    Route::put('/{id}', [TugasController::class, 'update'])->name('tugas.update');
    Route::delete('/{id}',[TugasController::class, 'destroy'])->name('tugas.destroy');
    Route::get('/{id}/show',[TugasController::class, 'show'])->name('tugas.show');
});
Route::prefix('submitan')->group(function(){
        //lihat submitan file untuk pembimbing
        Route::get('/pembimbing',[Pembimbing_tugas_Controller::class, 'indexpembimbing'])->name('pembimbing.tugas.index');
        Route::get('pembimbing/tugas/{id}',[Pembimbing_tugas_Controller::class, 'showpembimbing'])->name('pembimbing.tugas.show'); 
        Route::get('/pembimbing/{id}',[Pembimbing_tugas_Controller::class,'index_pembimbing'])->name('pembimbing.show.submitan');

        //lihat submitan file untuk penguji
        Route::get('/penguji',[penguji_tugas_Controller::class, 'indexpenguji'])->name('penguji.tugas.index');
     
});


//pembimbing oleh koordinator
Route::prefix('pembimbing')->group(function(){
    Route::get('/',[pembimbing_Controller::class, 'index'])->name('pembimbing.index');
    Route::get('/create', [pembimbing_Controller::class, 'create'])->name('pembimbing.create');
    Route::post('/', [pembimbing_Controller::class, 'store'])->name('pembimbing.store');
    Route::get('/{id}', [pembimbing_Controller::class, 'edit'])->name('pembimbing.edit');
    Route::put('/{id}', [pembimbing_Controller::class, 'update'])->name('pembimbing.update');
    Route::delete('/{id}',[pembimbing_Controller::class, 'destroy'])->name('pembimbing.destroy');
    Route::get('/{id}/show',[pembimbing_Controller::class, 'show'])->name('pembimbing.show');

});
//untuk pembimbing2
Route::prefix('pembimbing2')->group(function(){
    Route::get('/', [pembimbing_Controller::class, 'indexpembimbing2'])->name('pembimbing2.index');
    Route::get('/create', [pembimbing_Controller::class, 'createpembimbing2'])->name('pembimbing2.create');
    Route::post('/', [pembimbing_Controller::class, 'storepembimbing2'])->name('pembimbing2.store');
    Route::get('/{id}', [pembimbing_Controller::class, 'editpembimbing2'])->name('pembimbing2.edit');
    Route::put('/{id}', [pembimbing_Controller::class, 'updatepembimbing2'])->name('pembimbing2.update');
    Route::delete('/{id}', [pembimbing_Controller::class, 'destroypembimbing2'])->name('pembimbing2.destroy');
    Route::get('/{id}/show', [pembimbing_Controller::class, 'showpembimbing2'])->name('pembimbing2.show');
});

Route::prefix('penguji')->group(function(){
    Route::get('/',[Penguji_Controller::class, 'index'])->name('penguji.index');
    Route::get('/create', [Penguji_Controller::class, 'create'])->name('penguji.create');
    Route::post('/', [Penguji_Controller::class, 'store'])->name('penguji.store');
    Route::get('/{id}', [Penguji_Controller::class, 'edit'])->name('penguji.edit');
    Route::put('/{id}', [Penguji_Controller::class, 'update'])->name('penguji.update');
    Route::delete('/{id}',[Penguji_Controller::class, 'destroy'])->name('penguji.destroy');
    Route::get('/{id}/show',[Penguji_Controller::class, 'show'])->name('penguji.show');

});
//untuk pembimbing2
Route::prefix('penguji2')->group(function(){
    Route::get('/', [Penguji_Controller::class, 'indexpenguji2'])->name('penguji2.index');
    Route::get('/create', [Penguji_Controller::class, 'createpenguji2'])->name('penguji2.create');
    Route::post('/', [Penguji_Controller::class, 'storepenguji2'])->name('penguji2.store');
    Route::get('/{id}', [Penguji_Controller::class, 'editpenguji2'])->name('penguji2.edit');
    Route::put('/{id}', [Penguji_Controller::class, 'updatepenguji2'])->name('penguji2.update');
    Route::delete('/{id}', [Penguji_Controller::class, 'destroypenguji2'])->name('penguji2.destroy');
    Route::get('/{id}/show', [Penguji_Controller::class, 'showpenguji2'])->name('penguji2.show');
});
//pengumuman untuk koordinator
Route::prefix('pengumuman')->group(function(){
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman/store', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    //untuk menampilkan pengumuman ke mahasiswa
    Route::get('/mahasiswa/pengumuman', [PengumumanController::class, 'mahasiswaIndex'])->name('pengumuman.mahasiswa.index');

    Route::get('/mahasiswa/pengumuman/{id}', [PengumumanController::class, 'showMahasiswa'])->name('pengumuman.showMahasiswa');
    //Pengumuman send Pembimbing 
    Route::get('/pembimbing/pengumuman', [PengumumanController::class, 'pembimbingIndex'])->name('pembimbing.pengumuman.index');
    Route::get('/pembimbing/pengumuman/{id}', [PengumumanController::class, 'showpembimbing'])->name('pengumuman.pembimbing.show');




Route::get('/mahasiswa/pengumuman', [PengumumanController::class, 'mahasiswaIndex'])->name('pengumuman.mahasiswa.index');
Route::get('/mahasiswa/pengumuman/{id}', [PengumumanController::class, 'showMahasiswa'])->name('pengumuman.showMahasiswa');

Route::get('/pembimbing/pengumuman', [PengumumanController::class, 'pembimbingIndex'])->name('pembimbing.pengumuman.index');
Route::get('/pembimbing/pengumuman/{id}', [PengumumanController::class, 'showpembimbing'])->name('pengumuman.pembimbing.show');



//Pengumuman by Koordinator
Route::prefix('pengumuman')->group(function()
{
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman/store', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    
});

//Pengumuman by Koordinator

Route::prefix('pengumuman')->group(function(){
    Route::get('/',[PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/{id}', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/{id}',[PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    Route::get('/{id}/show',[PengumumanController::class, 'show'])->name('pengumuman.show');
    Route::get('/pengumuman/mahasiswa',[PengumumanController::class, 'showMahasiswa'])->name('pengumuman.mahasiswa.index');
});
// request bimbingan oleh mahasiswa
Route::prefix('bimbingan')->group(function(){
    Route::get('/',[BimbinganController::class, 'index'])->name('bimbingan.index');
    Route::get('/create', [BimbinganController::class, 'create'])->name('bimbingan.create');
    Route::post('/', [BimbinganController::class, 'store'])->name('bimbingan.store');
    Route::get('/{id}', [BimbinganController::class, 'edit'])->name('bimbingan.edit');
    Route::put('/{id}', [BimbinganController::class, 'update'])->name('bimbingan.update');
    Route::delete('/{id}',[BimbinganController::class, 'destroy'])->name('bimbingan.destroy');
    Route::get('/{id}/show',[BimbinganController::class, 'show'])->name('bimbingan.show');
});
//request bimbingan dosen pembimbing

    Route::get('/pengumuman/show/{id}', [PengumumanController::class, 'showPengumuman'])->name('pengumuman.show');
    //untuk koordinator
    Route::get('/show/koordinator',[PengumumanController::class,'showPengumumanKoordinator'])->name('pengumuman.koordinator.show');
    Route::get('/show/koordinator/{id}', [PengumumanController::class, 'showPengumumankoordinator'])->name('pengumuman.koordinator.show');
    //untuk pembimbing
    Route::get('/show/pembimbing/', [PengumumanController::class, 'pembimbingIndex'])->name('pengumuman.pembimbing.index');
    Route::get('/show/pembimbing/{id}', [PengumumanController::class, 'showPengumumanpembimbing'])->name('pengumuman.pembimbing.show');
    //Route untuk staff =>pengumuman
    Route::get('/BAAK',[PengumumanController::class, 'staffpengumuman'])->name('pengumuman.BAAK.index');
    Route::get('/BAAK/create',[PengumumanController::class, 'createpengumuman'])->name('pengumuman.BAAK.create');
    Route::post('/BAAK/store',[PengumumanController::class,'storepengumuman'])->name('pengumuman.BAAK.store');
    Route::get('/BAAK/pengumuman/edit/{id}', [PengumumanController::class, 'editpengumuman'])->name('pengumuman.BAAK.edit');
    Route::put('/BAAK/pengumuman/{id}', [PengumumanController::class, 'updatepengumuman'])->name('pengumuman.BAAK.update');
    Route::delete('/BAAK/pengumuman/{id}',[PengumumanController::class,'destroypengumuman'])->name('pengumuman.BAAK.destroy');
    Route::get('/pengumuman/show/BAAK/{id}', [PengumumanController::class, 'showPengumumanBAAK'])->name('pengumuman.BAAK.show');
    });

    //Route untuk BAAK =>tahun ajaran
    Route::prefix('TahunMasuk')->group(function(){
        Route::get('/',[TahunMasuk_Controller::class,'index'])->name('TahunMasuk.index');
        Route::get('/create',[TahunMasuk_Controller::class,'create'])->name('TahunMasuk.create');
        Route::post('/',[TahunMasuk_Controller::class, 'store'])->name('TahunMasuk.store');
        Route::get('/edit/{id}', [TahunMasuk_Controller::class, 'edit'])->name('TahunMasuk.edit');
        Route::put('/{id}', [TahunMasuk_Controller::class, 'update'])->name('TahunMasuk.update');
        Route::delete('/{id}',[TahunMasuk_Controller::class, 'destroy'])->name('TahunMasuk.destroy');

    });

     //Route untuk Koordinator =>Nilai Kelompok
Route::prefix('NilaiKelompok')->group(function(){
        Route::get('/',[NilaiKelompok_Controller::class,'index'])->name('NilaiKelompok.index');
        Route::post('/nilai-kelompok', [NilaiKelompok_Controller::class, 'store'])->name('NilaiKelompok.store');
        Route::put('/{id}',[NilaiKelompok_Controller::class, 'update'])->name('NilaiKelompok.update');
        Route::delete('/{id}',[NilaiKelompok_Controller::class, 'destroy'])->name('NilaiKelompok.destroy');

});
Route::prefix('NilaiMahasiswa')->group(function(){
        Route::get('/',[NilaiMahasiswa_Controller::class,'index'])->name('NilaiMahasiswa.index');
        Route::post('/nilai-kelompok', [NilaiMahasiswa_Controller::class, 'store'])->name('NilaiMahasiswa.store');
        Route::put('/{id}',[NilaiMahasiswa_Controller::class, 'update'])->name('NilaiMahasiswa.update');
        Route::delete('/{id}',[NilaiMahasiswa_Controller::class, 'destroy'])->name('NilaiMahasiswa.destroy');

});
    

//request bimbingan untuk dosen pembimbing

Route::prefix('dosenpembimbing')->group(function(){
    Route::get('/',[BimbinganController::class, 'indexpembimbing'])->name('pembimbing.bimbingan.index');
    Route::get('/{id}', [BimbinganController::class, 'setuju'])->name('pembimbing.bimbingan.setujui');
    Route::put('/{id}', [BimbinganController::class, 'tolak'])->name('pembimbing.bimbingan.tolak');
});

//artefak untuk mahasiswa
Route::prefix('artefak')->group(function(){
    Route::get('/',[Artefak_Controller::class, 'index'])->name('artefak.index');
    Route::get('/create/{id}', [Artefak_Controller::class, 'create'])->name('artefak.create');
    Route::post('/{id}', [Artefak_Controller::class, 'submit'])->name('artefak.submit');
    Route::get('/edit/{id}',[Artefak_Controller::class, 'edit'])->name('artefak.edit');
    Route::put('/{id}',[Artefak_Controller::class, 'update'])->name('artefak.update');

    //untuk menampilkan kepada dosen koordinator
    Route::get('/koordinator/{id}',[Artefak_Controller::class,'index_koordinator'])->name('artefak.index.koordinator');
    //untuk menampilkan kepada dosen pembimbing
   
});

// Jadwal dari dosen 
Route::prefix('jadwal')->group(function(){
    Route::get('/',[JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/{id}', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/{id}',[JadwalController::class, 'destroy'])->name('jadwal.destroy');
    // Route::get('/{id}/show',[JadwalController::class, 'show'])->name('jadwal.show');
});

// Jadwal mahasiswa
Route::get('/mahasiswa/jadwal',  [JadwalMahasiswaController::class, 'index'])->name('mahasiswa.jadwal.index');





// request bimbingan oleh mahasiswa




// request bimbingan oleh mahasiswa

Route::prefix('bimbingan')->group(function(){
    Route::get('/',[BimbinganController::class, 'index'])->name('bimbingan.index');
    Route::get('/create', [BimbinganController::class, 'create'])->name('bimbingan.create');
    Route::post('/', [BimbinganController::class, 'store'])->name('bimbingan.store');
    Route::get('/{id}', [BimbinganController::class, 'edit'])->name('bimbingan.edit');
    Route::put('/{id}', [BimbinganController::class, 'update'])->name('bimbingan.update');
    Route::delete('/{id}',[BimbinganController::class, 'destroy'])->name('bimbingan.destroy');
    Route::get('/{id}/show',[BimbinganController::class, 'show'])->name('bimbingan.show');
    Route::get('/kartu-bimbingan/{id}', [BimbinganController::class, 'showKartuBimbingan'])->name('bimbingan.kartu');
    Route::get('/export-pdf/{id}', [BimbinganController::class, 'exportToPdf'])->name('bimbingan.exportPdf');

});

//request bimbingan dosen pembimbing
Route::prefix('dosenpembimbing')->group(function(){
    Route::get('/',[BimbinganController::class, 'indexpembimbing'])->name('pembimbing.bimbingan.index');
    Route::get('/{id}', [BimbinganController::class, 'setuju'])->name('pembimbing.bimbingan.setujui');
    Route::put('/{id}', [BimbinganController::class, 'tolak'])->name('pembimbing.bimbingan.tolak');
});


// artefak oleh mahasiswa
Route::prefix('artefak')->group (function(){
    Route::get('/',[Artefak_Controller::class, 'index'])->name('artefak.index');
    Route::get('/create/{id}', [Artefak_Controller::class, 'create'])->name('artefak.create');
    Route::post('/{id}', [Artefak_Controller::class, 'submit'])->name('artefak.submit');
    Route::get('/edit/{id}',[Artefak_Controller::class, 'edit'])->name('artefak.edit');
    Route::put('/{id}',[Artefak_Controller::class, 'update'])->name('artefak.update');

    //untuk menampilkan kepada dosen koordinator
    Route::get('/koordinator/{id}',[Artefak_Controller::class,'index_koordinator'])->name('artefak.index.koordinator');
    //untuk menampilkan kepada dosen pembimbing
});



// Routes untuk Mahasiswa
Route::prefix('pengajuan-seminar')->name('PengajuanSeminar.')->group(function () {
    Route::get('/', [PengajuanSeminarController::class, 'index'])->name('index');
    Route::get('/create', [PengajuanSeminarController::class, 'create'])->name('create');
    Route::post('/', [PengajuanSeminarController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PengajuanSeminarController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PengajuanSeminarController::class, 'update'])->name('update');
    Route::delete('/{id}', [PengajuanSeminarController::class, 'destroy'])->name('destroy');
});

// Routes untuk Pembimbing
Route::prefix('pembimbing-pengajuan-seminar')->name('PembimbingPengajuanSeminar.')->group(function () {
    Route::get('/', [PengajuanSeminarController::class, 'indexPembimbing'])->name('index');
    Route::put('/{id}/setujui', [PengajuanSeminarController::class, 'setujui'])->name('setujui');
    Route::put('/{id}/tolak', [PengajuanSeminarController::class, 'tolak'])->name('tolak');
});