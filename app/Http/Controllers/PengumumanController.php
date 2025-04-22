<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\DosenRole;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    // Menampilkan pengumuman berdasarkan prodi_id dari session
    public function index()
    {
        // Mengambil prodi_id dari session
        $prodi_id = session('prodi_id');
    
        // Pastikan prodi_id ada di session
        if (!$prodi_id) {
            abort(403, 'Prodi ID tidak ditemukan.');
        }
    
        // Mengambil pengumuman yang hanya terkait dengan prodi_id yang sesuai
        $pengumuman = Pengumuman::where('prodi_id', $prodi_id)->get();
    
        return view('pages.Koordinator.pengumuman.index', compact('pengumuman'));
    }

    // Menampilkan form tambah pengumuman
    public function create()
    {
        // Pastikan koordinator atau role pengguna memiliki akses
        $dosenRole = DosenRole::where('user_id', session('user_id'))->first();

        if (!$dosenRole) {
            abort(403, 'Akses ditolak');
        }

        // Menampilkan form tambah pengumuman
        return view('pages.Koordinator.pengumuman.create');
    }

    // Menyimpan pengumuman
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
            'prodi_id' => 'required|exists:prodi,id',  // Validasi prodi_id yang ada di tabel prodi
        ]);
        
        // Mengambil data role dosen dari session
        $dosenRole = DosenRole::where('user_id', session('user_id'))->first();
    
        // Pastikan koordinator hanya bisa menambah pengumuman untuk prodi yang sesuai
        if (!$dosenRole || $dosenRole->prodi_id != $request->prodi_id) {
            return back()->withErrors(['prodi_id' => 'Anda tidak memiliki akses untuk membuat pengumuman di prodi ini.']);
        }
    
        // Menyimpan pengumuman
        Pengumuman::create([
            'judul' => $request->judul,
            'pengirim' => $request->pengirim,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'prodi_id' => $request->prodi_id,  // Mengambil prodi_id dari form
            'user_id' => session('user_id'),
        ]);
    
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    // Menampilkan form edit pengumuman
    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.Koordinator.pengumuman.edit', compact('pengumuman'));
    }

    // Menyimpan update data pengumuman
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

    public function mahasiswaIndex()
    {
        // Mengambil prodi_id dari session
        $prodi_id = session('prodi_id');
    
        // Pastikan prodi_id ada di session
        if (!$prodi_id) {
            abort(403, 'Prodi ID tidak ditemukan.');
        }
    
        // Mengambil pengumuman yang hanya terkait dengan prodi_id yang sesuai dan status 'aktif'
        $pengumuman = Pengumuman::where('prodi_id', $prodi_id)->where('status', 'aktif')->get();
    
        return view('pages.Mahasiswa.Pengumuman.index', compact('pengumuman'));
    }

    public function showMahasiswa($id)
{
    // Find the pengumuman by its ID
    $pengumuman = Pengumuman::findOrFail($id);

    // Return the view with the pengumuman data
    return view('pages.Mahasiswa.Pengumuman.show', compact('pengumuman'));
}};
