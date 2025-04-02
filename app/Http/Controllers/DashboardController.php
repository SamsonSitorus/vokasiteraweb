<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan dashboard untuk Mahasiswa
    public function mahasiswa()
    {
        // Logika untuk mahasiswa, misalnya ambil data terkait mahasiswa
        return view('pages.mahasiswa.dashboard');  // Ganti dengan view yang sesuai
    }

    // Menampilkan dashboard untuk Dosen
    public function dosen()
    {
        // Logika untuk dosen, misalnya ambil data terkait dosen
        return view('pages.kordinator.dashboard');  // Ganti dengan view yang sesuai
    }

    public function BAAK()
    {
        // Logika untuk dosen, misalnya ambil data terkait dosen
        return view('pages.BAAK.dashboard');  // Ganti dengan view yang sesuai
    }
    
}
