<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Prodi;
use App\Models\TahunAjaran;
use App\Models\KategoriPA;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JadwalPengujiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $userID = session('user_id');
            $token = session('token');

            if (!$userID || !$token) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }

            // Ambil semua jadwal di mana user jadi penguji 1 atau penguji 2
            $jadwal = Jadwal::where('penguji1', $userID)
                        ->orWhere('penguji2', $userID)
                        ->orderBy('waktu', 'asc')
                        ->get();

            // Ambil data dosen dari API external
            $response = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

            $namaDosen = 'Tidak Ditemukan'; // default kalau gagal
            if ($response->successful()) {
                $dosenData = $response->json('data.dosen');
                foreach ($dosenData as $dosen) {
                    if ($dosen['user_id'] == $userID) {
                        $namaDosen = $dosen['nama'];
                        break;
                    }
                }
            }

            return view('pages.Penguji.jadwal.index', compact('jadwal', 'namaDosen'));
        } catch (\Exception $e) {
            Log::error('Error fetching jadwal penguji: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengambil data jadwal.');
        }
    }
}
