<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PengumumanController extends Controller
{
    // Menampilkan semua pengumuman
 
public function index()
{
    $pengumuman = Pengumuman::all(); 
    
    return view('pages.Koordinator.pengumuman.index', compact('pengumuman'));
}


    // Menampilkan form tambah pengumuman
    public function create()
    {
        return view('pages.Koordinator.pengumuman.create');
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        $userID = session('user_id');
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
            'created_at' => 'nullable|date', // Contoh validasi status
        ]);

        // dd(auth()->user());
        
        Pengumuman::create([
            'judul' => $request->judul,
            'pengirim' => $request->pengirim,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'created_at' => $request->created_at ?? now(),
            // 'user_id' => auth()->id(),// Ambil dari user yang login
            'user_id'=> $userID
        ]);

        return redirect()->route('pengumuman.index')
              ->with('success', 'Pengumuman berhasil ditambahkan.');
    }


    // Menampilkan form edit
public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.Koordinator.pengumuman.edit', compact('pengumuman'));
    }

    // Menyimpan update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengirim' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update([
            'judul' => $request->judul,
            'pengirim' => $request->pengirim,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
          
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

// Menghapus data pengumuman
public function destroy($id)
{
    $pengumuman = Pengumuman::findOrFail($id);
    $pengumuman->delete();

    return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
}


// Pengumuman untuk mahasiswa 

public function mahasiswaIndex()
{
    // Mengambil pengumuman dengan status aktif
    $pengumuman = Pengumuman::where('status', 'aktif')->get();

    return view('pages.Mahasiswa.Pengumuman.index', compact('pengumuman'));
}

public function showMahasiswa($id)
{
    $pengumuman = Pengumuman::findOrFail($id);
    return view('pages.Mahasiswa.pengumuman.show', compact('pengumuman'));
}

// // Pengumuman Dosen Pembimbing 


public function pembimbingIndex()
{
    // Ambil hanya pengumuman yang status-nya aktif
    $pengumuman = Pengumuman::where('status', 'aktif')->get();

    return view('pages.Pembimbing.Pengumuman.index', compact('pengumuman'));
}

public function showpembimbing($id)
{
    $pengumuman = Pengumuman::findOrFail($id);

    return view('pages.Pembimbing.Pengumuman.show', compact('pengumuman'));
}





}






