<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard',function(){
    return view('pages/dashboard');
});
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
