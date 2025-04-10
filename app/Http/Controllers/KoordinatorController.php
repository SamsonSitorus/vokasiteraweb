<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Models\DosenRole;
use App\Models\Role;
use GuzzleHttp\Client;
use Exception;


class KoordinatorController extends Controller
{
public function create()
{
    $token = session('token');

    if (!$token) {
        return response()->json(['error' => 'Unauthorized. Token not found.'], 401);
    }

    // Ambil daftar dosen dari API eksternal
    $responseDosen = Http::withHeaders([
        'Authorization' => "Bearer $token"
    ])->get(env('API_URL') . "library-api/dosen", [
        'limit' => 100
    ]);

    $dosen = [];
    if ($responseDosen->successful()) {
        $dosen = $responseDosen->json()['data']['dosen'] ?? [];
    }

    $role = ['koordinator']; // Set default role
    $dosenRole = [           // Inisialisasi kosong untuk form create
        'user_id' => '',
        'nama_dosen' => '',
        'prodi' => '',
        'tingkat' => '',
    ];

    return view('pages.BAAK.kordinator.create', compact('dosen', 'role', 'dosenRole'));
}
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

    public function index(Request $request){
        try {
            $response = Http::acceptJson()->get(env('API_URL2') . '/dosenroles/');
      
            $dosen_roles = $response->json(); 
        return view('pages.BAAK.kordinator.index', compact('dosen_roles'));
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Gagal mengambil data dosen role']);
    }
  }


  public function destroy(Request $request,$id)
  {
      try {
          $response = Http::acceptJson()->delete(env('API_URL2') . '/dosenroles/' . $id);
  
          if ($response->successful()) {
              return redirect()->route('koordinator.index')->with('success', 'Dosen role berhasil dihapus.');
          }
  
          $error = $response->json()['message'] ?? 'Gagal menghapus dosen role.';
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
          ])->get(env('API_URL2') . "/dosenroles/$id");
  
          if (!$response->successful()) {
              return back()->withErrors(['error' => 'Gagal mengambil data dosen role']);
          }
  
          $data = $response->json();
  
          if (!is_array($data)) {
              return back()->withErrors(['error' => 'Format data tidak sesuai']);
          }
  
          // Ambil data dari satu user_id saja, gabungkan role_id dan nama_role
          $dosenRole = [
              'id'         => $data[0]['id'], // ambil id pertama, karena ID per role unik
              'user_id'    => $data[0]['user_id'],
              'nama_dosen' => $data[0]['nama_dosen'],
              'prodi'      => $data[0]['prodi'],
              'tingkat'    => $data[0]['tingkat'],
              'role_ids'   => array_column($data, 'role_id'),
              'role_names' => array_column($data, 'nama_role'),
          ];
  
          // Ambil semua dosen & role
          $responseDosen = Http::withHeaders([
              'Authorization' => "Bearer $token"
          ])->get(env('API_URL') . 'library-api/dosen', [
              'limit' => 100
          ]);
  
          $responseRole = Http::acceptJson()->get(env('API_URL2') . '/roles');
  
          $dosen = $responseDosen->successful() ? ($responseDosen->json()['data']['dosen'] ?? []) : [];
          $role  = $responseRole->successful() ? $responseRole->json() : [];
  
          return view('pages.BAAK.kordinator.edit', compact('dosenRole', 'dosen', 'role'));
  
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
  
          // 🔧 Fix ini
          $id = Crypt::decrypt($id);
  
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
          ])->put(env('API_URL2') . "/dosenroles/{$id}", [
             'user_id'    => (int) $validated['user_id'],
            'nama_dosen' => $validated['nama'],
            'prodi'      => $validated['prodi'],
            'tingkat'    => (int) $validated['tingkat'],
            'role_id'    => (int) $validated['role_id'],
            'nama_role'  => $validated['role_name'],
              
          ]);
  
          if (!$response->successful()) {
            return back()->withErrors(['api' => 'Gagal update ke API: ' . $response->body()]);
        }
        
        
        
          return redirect()->route('koordinator.index')->with('success', 'Data berhasil diupdate.');
      } catch (\Exception $e) {
          return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
      }
  }
  
}  