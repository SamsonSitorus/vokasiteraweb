<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Models\Kelompok;
class Artefak_Controller extends Controller
{
    public function index(Request $request){
        
        $prodi_id = session('prodi_id');
        $KPA_id = session('KPA_id');
        $TA_id = session('TA_id');
        
        $artefak =Tugas::with(['prodi', 'tahunAjaran', 'kategoripa'])
        ->where('prodi_id', $prodi_id)
        ->where('KPA_id', $KPA_id)
        ->where('TA_id', $TA_id)
        ->get();

            return view('pages.Mahasiswa.Artefak.index',compact('artefak'));
    }
}
