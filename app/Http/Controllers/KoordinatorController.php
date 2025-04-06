<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KoordinatorController extends Controller
{
    public function create()
    {
        $token = session('token');

        if (!$token) {
            return response()->json(['error' => 'Unauthorized. Token not found.'], 401);
        }

        // Kirim request ke API dengan token
        $responseDosen = Http::withHeaders([
            'Authorization' => "Bearer $token"
        ])->get(env('API_URL') . "library-api/dosen", [
            'nama' => '',
            'nidn' => '',
            'nip' => '',
            'user_id' => '',
            'pegawaiid' => '',
            'dosenid' => '',
            'limit' => 10
        ]);

        $responseRole = Http::get(env('API_URL2') . "/roles");

        $dosen = [];
        $role = [];
    
        if ($responseDosen->successful()) {
            $dosen = $responseDosen->json()['data']['dosen'] ?? [];
        }
    
        if ($responseRole->successful()) {
            $role = $responseRole->json(); 
        }
    
        return view('pages.BAAK.kordinator.create', compact('dosen', 'role'));

    }
}