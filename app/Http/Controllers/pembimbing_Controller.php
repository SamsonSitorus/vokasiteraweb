<?php

namespace App\Http\Controllers;

use App\Models\DosenRole;
use App\Models\Kelompok;
use App\Models\pembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Psy\TabCompletion\Matcher\FunctionDefaultParametersMatcher;

class pembimbing_Controller extends Controller
{
  public function index (){
    $token = session('token');
    $prodi_id = session('prodi_id');
    $KPA_id = session('KPA_id');
    $TA_id = session('TA_id');
    $pembimbing = pembimbing::with('kelompok')
    ->whereHas('kelompok', function ($query) use ($prodi_id, $KPA_id, $TA_id) {
      $query->where('prodi_id', $prodi_id)
            ->where('KPA_id', $KPA_id)
            ->where('TA_id', $TA_id);
  })
  ->get();
      // Ambil data dosen dari API eksternal
      $responseDosen = Http::withHeaders([
        'Authorization' => "Bearer $token"
    ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

    // Cek apakah request ke API sukses
    if ($responseDosen->successful()) {
        $dosen_list = $responseDosen->json()['data']['dosen'] ?? [];
        
        // Buat map user_id => nama
        $dosen_map = collect($dosen_list)->keyBy('user_id');
        
        // Tambahkan nama dosen ke setiap data dosen_roles
        $pembimbing->transform(function ($role) use ($dosen_map) {
            $role->nama = $dosen_map[$role->user_id]['nama'] ?? 'N/A';
            return $role;
        });
    } else {
        // Tangani jika API gagal
        $pembimbing->each(function ($role) {
            $role->nama = 'N/A'; // Tampilkan N/A jika API gagal
        });
    }
    

    return view('pages.Koordinator.pembimbing.index',compact('pembimbing'));
  }

  public function create(){
    $token = session('token');
    
    //  Ambil data dosen dari API eksternal
       $responseDosen = Http::withHeaders([
        'Authorization' => "Bearer $token"
    ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

    $dosenApiMap = collect();
      // Buat map user_id => nam
      if ($responseDosen->successful()){
        $dosenlist = $responseDosen->json()['data']['dosen'] ?? [];
        $dosenApiMap =  collect($dosenlist)->keyBy('user_id');
      }
      //ambil data dosen berdasarkan session
        $prodi_id = session('prodi_id');
        $KPA_id = session('KPA_id');
        $TA_id = session('TA_id');
       
          $dosen = DosenRole::with(['prodi', 'tahunAjaran', 'kategoripa','role'])
          ->where('prodi_id', $prodi_id)
          ->where('KPA_id', $KPA_id)
          ->where('TA_id', $TA_id)
          ->whereHas('role', function ($query) {
            $query->where('role_name', 'pembimbing 1');
        })
          ->get();
      // Ambil nama dosen dari data API berdasarkan user_id
      $dosenFinal = $dosen->map(function ($dr) use ($dosenApiMap) {
        return [
            'user_id' => $dr->user_id,
            'nama' => $dosenApiMap[$dr->user_id]['nama'] ?? 'Nama Tidak Diketahui',
            'prodi' => $dr->prodi->nama_prodi ?? '',
            'role' => $dr->role->role_name ?? '',
            'tahun_ajaran' => $dr->tahunAjaran->tahun ?? '',
            'kategori' => $dr->kategoripa->nama_kategori ?? '',
        ];
      });

    $Kelompok = Kelompok::with(['prodi', 'tahunAjaran', 'kategoripa'])
    ->where('prodi_id', $prodi_id)
    ->where('KPA_id', $KPA_id)
    ->where('TA_id', $TA_id)
    ->get();
    $kelompokIdsudahpunyapembimbing = DB ::table('pembimbing')->pluck('kelompok_id')->toArray();
    $kelompokbelummasuk =  $Kelompok->filter(function($klmpk)use($kelompokIdsudahpunyapembimbing){
        return !in_array($klmpk['id'],$kelompokIdsudahpunyapembimbing);
    })->values();

// dd($dosenApiMap);
    return view('pages.Koordinator.pembimbing.create',[
      'dosen' => $dosenFinal,
      'kelompok' => $kelompokbelummasuk,
    ]);
}

  public function store(Request $request){
      $validated = $request->validate([
        'user_id'   => 'required|numeric',
        'kelompok_id'  => 'required|array',
        'kelompok_id.*' => 'exists:kelompok,id',
      ]);

      foreach ($validated['kelompok_id'] as $kelompokId) {
        pembimbing::create([
            'user_id' => $validated['user_id'],
            'kelompok_id' => $kelompokId,
        ]);
      }
      return redirect()->route('pembimbing.index')->with('succes', 'Data Berhasil disimpan');
  }
  public function edit ($encryptedId){
     try{
          // Dekripsi ID
          $id = Crypt::decrypt($encryptedId);

          $pembimbing = pembimbing::all();
          
        return view('pages.Koordinator.pembimbing.edit',compact('pembimbing'));
        
    } catch (Exception $e) {
      return redirect()->back()->with('error', 'Gagal menampilkan data: ' . $e->getMessage());
  }
  }
  public Function destroy ($id){
      try {

        $pembimbing =  pembimbing::findOrfail($id);

        $pembimbing->delete();
      return redirect()->back()->with('success', 'Data kelompok berhasil dihapus.');
    } catch (Exception $e) {
        return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
  }
}
   