<?php

namespace App\Http\Controllers;

use App\Models\kategoriPA;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TahunAjaran;
class NilaiMahasiswa_Controller extends Controller
{
    public function index(){
        $prodi_id = session('prodi_id');
        // $KPA_id = session('KPA_id');
        $TA_id = session('TA_id');
        $token = session('token');
        $TahunAjaran =TahunAjaran::where('id', $TA_id)->value('Tahun_Ajaran');
        $prodi = Prodi::where('id', $prodi_id)->value('nama_prodi');
        // $KPA = kategoriPA::where('id',$KPA_id)->value('kategori_pa');

        $responseMahasiswa = Http::withHeaders([
            'Authorization' => "Bearer $token"
        ])->get(env('API_URL') . "library-api/mahasiswa", [
            "angkatan" =>$TahunAjaran,
            "prodi" => $prodi,
            'limit' => 100]);
    
        $mahasiswa = $responseMahasiswa->successful()
            ? collect($responseMahasiswa->json()['data']['mahasiswa'] ?? [])
            ->sortBy('nim')
            ->values()
            : collect();

            return view('pages.Koordinator.Nilai_Mahasiswa.index', compact('mahasiswa')); 
    }
}
