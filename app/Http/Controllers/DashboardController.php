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
    public function koordinator()
    {
        // Logika untuk dosen, misalnya ambil data terkait dosen
        return view('pages.koordinator.dashboard');  // Ganti dengan view yang sesuai
    }

    public function penguji1()
    {
        // Logika untuk dosen, misalnya ambil data terkait dosen
        return view('pages.penguji1.dashboard');  // Ganti dengan view yang sesuai
    }
    public function penguji2()
    {
        // Logika untuk dosen, misalnya ambil data terkait dosen
        return view('pages.penguji2.dashboard');  // Ganti dengan view yang sesuai
    }
    public function pembimbing1()
    {
        // Logika untuk dosen, misalnya ambil data terkait dosen
        return view('pages.pembimbing1.dashboard');  // Ganti dengan view yang sesuai
    }

    public function pembimbing2()
    {
        // Logika untuk dosen, misalnya ambil data terkait dosen
        return view('pages.pembimbing2.dashboard');  // Ganti dengan view yang sesuai
    }


    public function BAAK()
    {
        // Logika untuk dosen, misalnya ambil data terkait dosen
        return view('pages.BAAK.dashboard');  // Ganti dengan view yang sesuai
    }
    
}
