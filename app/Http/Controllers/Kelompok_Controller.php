<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelompok;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
class Kelompok_Controller extends Controller
{
    
    public function index(Request $request)
    { 
        try {
            // Ambil data session prodi dan jenis_pa, jika belum ada ambil dari API
            if (!session()->has('prodi') || !session()->has('jenis_pa')) {
                $user_id = session('user_id');
                $responseRole = Http::acceptJson()->get(env('API_URL2') . '/dosenroles/');
                
                if ($responseRole->ok()) {
                    $roles = collect($responseRole->json());
                    $myRoles = $roles->where('user_id', $user_id);
                    $koordinator = $myRoles->firstWhere('nama_role', 'Koordinator');
                    
                    if ($koordinator) {
                        session([
                            'prodi' => $koordinator['prodi'],
                            'jenis_pa' => $koordinator['jenis_pa'],
                        ]);
                    } else {
                        return redirect()->back()->with('error', 'Anda bukan Koordinator.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Gagal mengambil data dari API.');
                }
            }
            // Ambil data kelompok dari API
            $response = Http::acceptJson()->get(env('API_URL2') . '/kelompok/');
            $kelompok = collect($response->json());
    
            // Filter data berdasarkan session prodi dan jenis_pa
            $filteredKelompok = $kelompok->where('Prodi', session('prodi'))
                                         ->where('JenisPA', session('jenis_pa'));
            
            $kelompok = $filteredKelompok;
            // dd([
            //     'session_prodi' => session('prodi'),
            //     'session_jenis_pa' => session('jenis_pa'),
            //     'data_kelompok' => $kelompok->pluck('prodi', 'id'), // atau 'Prodi' tergantung key
            // ]);
            return view('pages.Koordinator.kelompok.index', compact('kelompok'));
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengambil data Kelompok']);
        }
    }
    
  public function create()
  {
      $user_id = session('user_id');

      // Cek apakah session prodi dan jenis_pa belum ada
      if (!session()->has('prodi') || !session()->has('jenis_pa')) {

          // Panggil API semua dosen_roles
          $response =  Http::acceptJson()->get(env('API_URL2') . '/dosenroles/');

          if ($response->ok()) {
              $roles = collect($response->json());

              // Filter berdasarkan user_id yang sedang login
              $myRoles = $roles->where('user_id', $user_id);

              // Ambil role Koordinator
              $koordinator = $myRoles->firstWhere('nama_role', 'Koordinator');

              // Simpan prodi dan jenis_pa ke session
              if ($koordinator) {
                  session([
                      'prodi' => $koordinator['prodi'],
                      'jenis_pa' => $koordinator['jenis_pa'],
                  ]);
              } else {
                  return redirect()->back()->with('error', 'Anda bukan Koordinator.');
              }
          } else {
              return redirect()->back()->with('error', 'Gagal mengambil data dari API.');
          }
      }

      // Lanjut ke view tambah kelompok
      return view('pages.Koordinator.kelompok.create');
  }

  public function store(Request $request){
    try{
    $request->validate([
        'nomor' => 'required|string',
        'angkatan' => 'required|numeric',
    ]);

    Kelompok::create([
        'nomor' => $request->nomor,
        'angkatan' => $request->angkatan,
        'prodi' => session('prodi'),
        'jenis_pa' => session('jenis_pa'),
    ]);
   
    return redirect()->route('kelompok.index')->with('success', 'Kelompok berhasil ditambahkan.');
} catch (\Exception $e) {
   // Tambahan: kamu bisa log error-nya untuk debugging
   Log::error('Gagal create kelompok: '.$e->getMessage());
        
   return back()->withErrors(['error' => 'Gagal Create Kelompok']);
}
}

public function destroy(Request $request,$id)
  {
      try {
          $response = Http::acceptJson()->delete(env('API_URL2') . '/kelompok/' . $id);
  
          if ($response->successful()) {
              return redirect()->route('kelompok.index')->with('success', 'Kelompok berhasil dihapus.');
          }
  
          $error = $response->json()['message'] ?? 'Gagal menghapus Kelompok.';
          return back()->withErrors(['error' => $error]);
  
      } catch (\Exception $e) {
          return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
      }
  }
 
  public function edit($id)
  {
      try {
          $token = session('token');
          if (!$token) {
              return back()->withErrors(['error' => 'Unauthorized']);
          }
  
          $id = Crypt::decrypt($id);
          $response = Http::withHeaders([
              'Authorization' => "Bearer $token",
              'Accept' => 'application/json'
          ])->get(env('API_URL2') . "/kelompok/$id");
  
          if (!$response->successful()) {
              return back()->withErrors(['error' => 'Gagal mengambil data kelompok']);
          }
  
          $data = $response->json();
        //   dd($data);
          if (!is_array($data)) {
              return back()->withErrors(['error' => 'Format data tidak sesuai']);
          }
  
          $kelompok = [
              'id'       => $data['id'], 
              'nomor'    => $data['Nomor'],
              'jenis_pa' => $data['JenisPA'],
              'angkatan' => $data['Angkatan'],
              'prodi'    => $data['Prodi'],
          ];
         
          return view('pages.koordinator.kelompok.edit', compact('kelompok'));
  
      } catch (\Exception $e) {
          return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
      }
  }

    public function update(Request $request, $id)
    {
        try {
            $token = session('token');
            if (!$token) {
                return back()->withErrors(['error' => 'Unauthorized']);
            }
    
            $id = Crypt::decrypt($id);
        
            $validated = $request->validate([
                'nomor'      => 'required|string',
                'jenis_pa'   => 'required|string',
                'angkatan' => 'required|integer',
                'prodi'     => 'required|string',
            ]);
            
            $response = Http::withHeaders([
                'Authorization' => "Bearer $token",
                'Accept' => 'application/json'
            ])->put(env('API_URL2') . "/kelompok/{$id}", [
                'nomor'    => $validated['nomor'],
                'jenis_pa' => $validated['jenis_pa'],
                'prodi'    => $validated['prodi'],
                'angkatan' => (int)$validated['angkatan'],
                
            ]);
         
            if (!$response->successful()) {
                return back()->withErrors(['api' => 'Gagal update ke API: ' . $response->body()]);
            }
            
            return redirect()->route('kelompok.index')->with('success', 'Data berhasil diupdate.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    
}