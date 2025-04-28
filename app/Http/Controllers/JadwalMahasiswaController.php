<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelompok;
use App\Models\KelompokMahasiswa;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Http;

class JadwalMahasiswaController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $token = session('token');

        $kelompokMahasiswa = KelompokMahasiswa::with(['kelompok.jadwal', 'kelompok.pembimbing'])
            ->where('user_id', $userId)
            ->first();

        if (!$kelompokMahasiswa || !$kelompokMahasiswa->kelompok) {
            return back()->with('error', 'Anda belum tergabung dalam kelompok.');
        }

        $kelompok = $kelompokMahasiswa->kelompok;
        $jadwalUtama = $kelompok->jadwal;

        if (!$jadwalUtama) {
            return view('pages.Mahasiswa.jadwal.index', compact('kelompok'))
                ->with('error', 'Jadwal belum tersedia untuk kelompok Anda.');
        }

        $jadwalLain = Jadwal::with('kelompok')
            ->where('KPA_id', $jadwalUtama->KPA_id)
            ->where('prodi_id', $jadwalUtama->prodi_id)
            ->where('TA_id', $jadwalUtama->TA_id)
            ->where('id', '!=', $jadwalUtama->id)
            ->get();

        $jadwalSemua = collect([$jadwalUtama])->merge($jadwalLain);

        $responseDosen = Http::withHeaders([
            'Authorization' => "Bearer $token"
        ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

        $dosenData = $responseDosen->successful() ? $responseDosen->json()['data']['dosen'] : [];

        $dosenArray = [];
        foreach ($dosenData as $dosen) {
            $dosenArray[$dosen['user_id']] = $dosen['nama'];
        }

        foreach ($jadwalSemua as $jadwal) {
            $jadwal->penguji1_nama = $dosenArray[$jadwal->penguji1] ?? 'Tidak Ditemukan';
            $jadwal->penguji2_nama = $dosenArray[$jadwal->penguji2] ?? 'Tidak Ditemukan';
        }

        $pembimbingNama = [];
        if ($kelompok->pembimbing && $kelompok->pembimbing->isNotEmpty()) {
            foreach ($kelompok->pembimbing as $pembimbing) {
                $userId = $pembimbing->user_id;
                $pembimbingNama[] = $dosenArray[$userId] ?? 'Tidak Ditemukan';
            }
        }

        return view('pages.Mahasiswa.jadwal.index', [
            'jadwalUtama' => $jadwalUtama,
            'jadwalLain' => $jadwalLain,
            'jadwalSemua' => $jadwalSemua,
            'kelompok' => $kelompok,
            'pembimbingNama' => $pembimbingNama,
        ]);
    }
}
