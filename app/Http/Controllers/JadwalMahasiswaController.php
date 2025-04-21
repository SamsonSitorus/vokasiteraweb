<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelompok;
use App\Models\KelompokMahasiswa;
use Illuminate\Support\Facades\Http;

class JadwalMahasiswaController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $token = session('token');

        // Ambil data kelompok dan jadwalnya
        $kelompokMahasiswa = KelompokMahasiswa::with(['kelompok.jadwal'])
            ->where('user_id', $userId)
            ->first();

        if (!$kelompokMahasiswa || !$kelompokMahasiswa->kelompok) {
            return back()->with('error', 'Anda belum tergabung dalam kelompok.');
        }

        $kelompok = $kelompokMahasiswa->kelompok;
        $jadwal = $kelompok->jadwal;

        // Cek apakah jadwal tersedia
        if (!$jadwal) {
            return back()->with('error', 'Jadwal belum tersedia untuk kelompok Anda.');
        }

        // Ambil data dosen
        $responseDosen = Http::withHeaders([
            'Authorization' => "Bearer $token"
        ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

        $dosenData = $responseDosen->successful() ? $responseDosen->json()['data']['dosen'] : [];

        $dosenArray = [];
        foreach ($dosenData as $dosen) {
            $dosenArray[$dosen['user_id']] = $dosen['nama'];
        }

        // Tambahkan nama penguji ke objek jadwal
        $jadwal->penguji1_nama = $dosenArray[$jadwal->penguji1] ?? 'Tidak Ditemukan';
        $jadwal->penguji2_nama = $dosenArray[$jadwal->penguji2] ?? 'Tidak Ditemukan';

        return view('pages.Mahasiswa.jadwal.index', compact('jadwal', 'kelompok'));
    }
}
