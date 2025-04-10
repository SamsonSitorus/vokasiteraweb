<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class Kelompok_Controller extends Controller
{
    public function create()
{
    $token = session('token');

    if (!$token) {
        return response()->json(['error' => 'Unauthorized. Token not found.'], 401);
    }

    // Ambil daftar dosen dari API eksternal
    $responseMahasiswa = Http::withHeaders([
        'Authorization' => "Bearer $token"
    ])->get(env('API_URL') . "library-api/mahasiswa", [
        'limit' => 1000
    ]);

    $mahasiswa = [];
    if ($responseMahasiswa->successful()) {
        $mahasiswa = $responseMahasiswa->json()['data']['mahasiswa'] ?? [];
    }


    return view('pages.Koordinator.kelompok.create', compact('mahasiswa'));
}

    public function index(Request $request){
        try {
            $response = Http::acceptJson()->get(env('API_URL2') . '/kelompok/');
      
            $dosen_roles = $response->json(); 
        return view('pages.Koordinator.kelompok.index', compact('kelompok'));
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Gagal mengambil data dosen role']);
    }
  }
}
