<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
class penguji_tugas_Controller extends Controller
{
    public function indexpenguji(){
        
        $prodi_id = session('prodi_id');
        $KPA_id = session('KPA_id');
        $TA_id = session('TA_id');
        $user_id = session('user_id');

        $tugas = tugas::with(['prodi', 'tahunAjaran', 'kategoripa'])
        ->where('prodi_id', $prodi_id)
        ->where('KPA_id', $KPA_id)
        ->where('TA_id', $TA_id)
        ->where('user_id',$user_id)
        ->get();

        return view('pages.Penguji.tugas.index',compact('tugas'));
         

    }
}
