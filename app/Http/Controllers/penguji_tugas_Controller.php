<?php

namespace App\Http\Controllers;

use App\Models\pengumpulan_tugas;
use Illuminate\Http\Request;
use App\Models\Tugas;
class penguji_tugas_Controller extends Controller
{
    public function indexpenguji(){
        
        $prodi_id = session('prodi_id');
        $KPA_id = session('KPA_id');
        $TM_id = session('TM_id');
        $user_id = session('user_id');

        $tugas = tugas::with(['prodi', 'tahunMasuk', 'kategoripa'])
        ->where('prodi_id', $prodi_id)
        ->where('KPA_id', $KPA_id)
        ->where('TM_id', $TM_id)
        ->get();

        return view('pages.Penguji.tugas.index',compact('tugas'));
         

    }
    public function showpenguji($id)
    {
        $tugas = Tugas::findOrFail($id);
        // dd($tugas);
        return view('pages.Penguji.tugas.show', compact('tugas'));
    }

    public function index_penguji($id){
        $prodi_id = session('prodi_id');
        $KPA_id = session('KPA_id');
        $TM_id = session('TM_id');
        $user_id = session('user_id');

        $artefak = pengumpulan_tugas::with(['kelompok.penguji','tugas'])
            ->where('tugas_id', $id)// ambil berdasarkan tugas_id = $id
            ->whereHas('kelompok',function ($query) use ($user_id){
                $query->whereHas('penguji', function ($q ) use ($user_id){
                    $q->where('user_id',$user_id);

                });
            }) 
            ->whereHas('tugas', function ($query) use ($prodi_id, $KPA_id, $TM_id) {
                $query->where('prodi_id', $prodi_id)
                      ->where('KPA_id', $KPA_id)
                      ->where('TM_id', $TM_id);
            })
            ->get();
        return view('pages.penguji.tugas.show_submission', compact('artefak'));
    }
}
