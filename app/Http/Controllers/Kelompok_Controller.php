<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Kelompok_Controller extends Controller
{
    public function index(Request $request)
    {
        try {
            $user_id = session('user_id');
            $dosen = Http::get(env('API_URL2') . "/dosenroles/user/{$user_id}")->json();
    
            $response = Http::acceptJson()->get(env('API_URL2') . '/kelompok/');
            $kelompokAll = $response->json();
    
            // Mapping Prodi (TRPL -> DIV Teknologi Rekayasa Perangkat Lunak)
            $prodiMap = [
                'TRPL' => 'DIV Teknologi Rekayasa Perangkat Lunak',
                'TI'   => 'DIII Teknologi Komputer',
                'TK'   => 'DIII Teknologi Informasi',
            ];
    
            $filteredKelompok = [];
    
            foreach ($dosen as $d) {
                if ($d['nama_role'] === 'Koordinator') {
                    $prodi = $prodiMap[$d['prodi']] ?? $d['prodi'];
                    $angkatan = now()->year - $d['tingkat'] + 1;
    
                    $filtered = collect($kelompokAll)->filter(function ($item) use ($prodi, $angkatan) {
                        return strtolower($item['Prodi']) == strtolower($prodi)
                            && (int)$item['Angkatan'] == $angkatan;
                    });
    
                    $filteredKelompok = array_merge($filteredKelompok, $filtered->toArray());
                }
            }
    
            return view('pages.Koordinator.kelompok.index', ['kelompok' => $filteredKelompok]);
    
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengambil data Kelompok']);
        }
    }
    
//     public function index(Request $request){
//         dd(session()->all()); 
//         try {
//             $response = Http::acceptJson()->get(env('API_URL2') . '/kelompok/');
      
//             $kelompok = $response->json(); 
//         return view('pages.Koordinator.kelompok.index',compact('kelompok'));
//     } catch (\Exception $e) {
//         return back()->withErrors(['error' => 'Gagal mengambil data Kelompok']);
//     }
//   }
  public function store(Request $request)
  {
      $token = session('token');
  
      if (!$token) {
          return response()->json(['error' => 'Unauthorized.'], 401);
      }
      $validated = $request->validate([
          'user_id'   => 'required|numeric',
          'nama'      => 'required|string',
          'role_id'   => 'required|integer',
          'role_name' => 'required|string',
          'prodi'     => 'required|string',
          'tingkat'   => 'required|numeric',
      ]);
      
      $response = Http::withHeaders([
          'Authorization' => "Bearer $token",
          'Accept' => 'application/json'
      ])->post(env('API_URL2') . '/dosenroles', [
          'user_id'    => (int) $validated['user_id'],
          'nama_dosen' => $validated['nama'],
          'prodi'      => $validated['prodi'],
          'tingkat'    => (int) $validated['tingkat'],
          'role_id'    => (int) $validated['role_id'],
          'nama_role'  => $validated['role_name'],
      ]);
      
      if (!$response->successful()) {
          return back()->withErrors(['api' => 'Gagal menyimpan ke API: ' . $response->body()]);
      }
  
      return redirect()->route('koordinator.index')->with('success', 'Data berhasil disimpan.');
  }
  
}
