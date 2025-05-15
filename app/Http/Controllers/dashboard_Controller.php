<?php

namespace App\Http\Controllers;

use App\Models\DosenRole;
use App\Models\Jadwal;
use App\Models\Kelompok;
use App\Models\KelompokMahasiswa;
use App\Models\pembimbing;
use App\Models\Penguji;
use App\Models\Pengumuman;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class dashboard_Controller extends Controller
{
   public function Koordinator() {
    $KPA_id = session('KPA_id');
    $prodi_id = session('prodi_id');
    $TM_id = session('TM_id');
    $user_id = session('user_id');

    $jumlah_mahasiswa = KelompokMahasiswa::with('kelompok')
        ->whereHas('kelompok', function ($q) use ($KPA_id, $prodi_id, $TM_id) {
            $q->where('KPA_id', $KPA_id);
            $q->where('prodi_id', $prodi_id);
            $q->where('TM_id', $TM_id);
        })
        ->count();

    $jumlah_pengumuman = Pengumuman::where('KPA_id', $KPA_id)
        ->where('prodi_id', $prodi_id)
        ->where('TM_id', $TM_id)
        ->count();

    $jumlah_dosen = DosenRole::where('KPA_id', $KPA_id)
        ->where('prodi_id', $prodi_id)
        ->where('TM_id', $TM_id)
        ->count();

    $jumlah_tugas = Tugas::where('KPA_id', $KPA_id)
        ->where('prodi_id', $prodi_id)
        ->where('TM_id', $TM_id)
        ->count();
    $jadwal = Jadwal::with('kelompok')
        ->where('KPA_id', $KPA_id)
        ->where('prodi_id', $prodi_id)
        ->where('TM_id', $TM_id)
        ->get();
       
  $events = $jadwal->map(function ($item) {
    return [
        'title' => 'Kelompok ' . $item->kelompok->nomor_kelompok. 'seminar  ',
        'start' => Carbon::parse($item->waktu_mulai)->toIso8601String(),
        'end' => Carbon::parse($item->waktu_selesai)->toIso8601String(),
    ];
});

    return view('pages.Koordinator.dashboard', compact('jumlah_mahasiswa', 'jumlah_pengumuman','jumlah_dosen','jumlah_tugas','events'));
}
  public function pembimbing() {
    $KPA_id = session('KPA_id');
    $prodi_id = session('prodi_id');
    $TM_id = session('TM_id');
    $user_id = session('user_id');

    $jumlah_kelompok = pembimbing::where('user_id', $user_id)
        ->count();
     $jumlah_pengumuman = Pengumuman::where('KPA_id', $KPA_id)
        ->where('prodi_id', $prodi_id)
        ->where('TM_id', $TM_id)
        ->count();
     $jumlah_tugas = Tugas::where('KPA_id', $KPA_id)
        ->where('prodi_id', $prodi_id)
        ->where('TM_id', $TM_id)
        ->count();
     $jadwal = Jadwal::with('kelompok')
        ->where('KPA_id', $KPA_id)
        ->where('prodi_id', $prodi_id)
        ->where('TM_id', $TM_id)
        ->get();
       
    $events = $jadwal->map(function ($item) {
        return [
            'title' => 'Kelompok ' . $item->kelompok->nomor_kelompok. 'seminar  ',
            'start' => Carbon::parse($item->waktu_mulai)->toIso8601String(),
            'end' => Carbon::parse($item->waktu_selesai)->toIso8601String(),
        ];
    });

   return view('pages.Pembimbing.dashboard',compact('jumlah_kelompok','jumlah_pengumuman','events','jumlah_tugas'));

}
 public function penguji() {
    $KPA_id = session('KPA_id');
    $prodi_id = session('prodi_id');
    $TM_id = session('TM_id');
    $user_id = session('user_id');

    $jumlah_kelompok = Penguji::where('user_id', $user_id)
        ->count();
     $jumlah_pengumuman = Pengumuman::where('KPA_id', $KPA_id)
        ->where('prodi_id', $prodi_id)
        ->where('TM_id', $TM_id)
        ->count();
     $jumlah_tugas = Tugas::where('KPA_id', $KPA_id)
        ->where('prodi_id', $prodi_id)
        ->where('TM_id', $TM_id)
        ->count();
     $jadwal = Jadwal::with('kelompok')
        ->where('KPA_id', $KPA_id)
        ->where('prodi_id', $prodi_id)
        ->where('TM_id', $TM_id)
        ->get();
       
    $events = $jadwal->map(function ($item) {
        return [
            'title' => 'Kelompok ' . $item->kelompok->nomor_kelompok. 'seminar  ',
            'start' => Carbon::parse($item->waktu_mulai)->toIso8601String(),
            'end' => Carbon::parse($item->waktu_selesai)->toIso8601String(),
        ];
    });

   return view('pages.Penguji.dashboard',compact('jumlah_kelompok','jumlah_pengumuman','events','jumlah_tugas'));

}
public function mahasiswa(){
    $user_id = session('user_id');
$token = session('token');

// Ambil kelompok_id berdasarkan user_id
$kelompok_id = KelompokMahasiswa::where('user_id', $user_id)->value('kelompok_id');

$mahasiswa_kelompok = collect();
$pembimbing = collect();

if ($kelompok_id) {
    // Ambil semua anggota kelompok
    $mahasiswa_kelompok = KelompokMahasiswa::where('kelompok_id', $kelompok_id)->get();

    // Ambil data mahasiswa dari API
    $mahasiswaResponse = Http::withHeaders([
        'Authorization' => "Bearer $token"
    ])->get(env('API_URL') . "library-api/mahasiswa");

    $mahasiswa_map = collect();

    if ($mahasiswaResponse->successful()) {
        $data = $mahasiswaResponse->json();
        $listMahasiswa = $data['data']['mahasiswa'] ?? [];

        // Buat map: user_id => mahasiswa
        $mahasiswa_map = collect($listMahasiswa)->keyBy('user_id');
    }

    // Tambahkan data nama, nim, angkatan ke masing-masing anggota
    $mahasiswa_kelompok = $mahasiswa_kelompok->map(function ($item) use ($mahasiswa_map) {
        $mhs = $mahasiswa_map->get($item->user_id);
        $item->nama = $mhs['nama'] ?? 'N/A';
        $item->nim = $mhs['nim'] ?? 'N/A';
        $item->angkatan = $mhs['angkatan'] ?? 'N/A';
        return $item;
    });

    // Ambil user_id pembimbing kelompok
    $pembimbing_ids = pembimbing::where('kelompok_id', $kelompok_id)->pluck('user_id');

    // Ambil data dosen dari API
    $dosenResponse = Http::withHeaders([
        'Authorization' => "Bearer $token"
    ])->get(env('API_URL') . "library-api/dosen");

    $dosen_map = collect();

    if ($dosenResponse->successful()) {
        $data = $dosenResponse->json();
        $listDosen = $data['data']['dosen'] ?? [];

        // Buat map: user_id => dosen
        $dosen_map = collect($listDosen)->keyBy('user_id');
    }

    // Ubah data pembimbing: isikan nama
    $pembimbing = $pembimbing_ids->map(function ($id) use ($dosen_map) {
        return (object)[
            'user_id' => $id,
            'nama' => $dosen_map->get($id)['nama'] ?? 'N/A'
        ];
    });
    $penguji_ids = penguji::where('kelompok_id', $kelompok_id)->pluck('user_id');
     $penguji = $penguji_ids->map(function ($id) use ($dosen_map) {
        return (object)[
            'user_id' => $id,
            'nama' => $dosen_map->get($id)['nama'] ?? 'N/A'
        ];
    });
    }

    $jadwal = Jadwal::with(['kelompok','ruangan'])
    ->where('kelompok_id', $kelompok_id)->get();

return view('pages.Mahasiswa.dashboard', compact('mahasiswa_kelompok', 'pembimbing','penguji','jadwal'));


    }
  
    
}
