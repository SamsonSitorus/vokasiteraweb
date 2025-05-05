<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\pengumpulan_tugas;
class Pembimbing_tugas_Controller extends Controller
{
    public function indexpembimbing(Request $request){

        $prodi_id = session('prodi_id');
        $KPA_id = session('KPA_id');
        $TM_id = session('TM_id');
        $user_id = session('user_id');

      $tugas = tugas::with(['prodi', 'tahunMasuk', 'kategoripa'])
      ->where('prodi_id', $prodi_id)
      ->where('KPA_id', $KPA_id)
      ->where('TM_id', $TM_id)
      ->where('user_id',$user_id)
      ->get();
    
      return view('pages.Pembimbing.tugas.index',compact('tugas'));
       
    }
    public function showpembimbing($id)
    {
        $tugas = Tugas::findOrFail($id);
        // dd($tugas);
        return view('pages.Pembimbing.tugas.show', compact('tugas'));
    }
    public function formFeedback($id)
    {
        $user_id = session('user_id');

        $artefak = pengumpulan_tugas::with('kelompok.pembimbing')
            ->where('id', $id)
            ->whereHas('kelompok.pembimbing', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->firstOrFail();

        return view('pages.pembimbing.tugas.feedback_form', compact('artefak'));
    }

    public function submitFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback_pembimbing' => 'required|string|max:1000',
        ]);

        $user_id = session('user_id');

        $artefak = pengumpulan_tugas::with('kelompok.pembimbing')
            ->where('id', $id)
            ->whereHas('kelompok.pembimbing', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->firstOrFail();

        $artefak->feedback_pembimbing = $request->feedback_pembimbing;
        $artefak->save();

        return redirect()->route('pembimbing.show.submitan', $artefak->tugas_id)
            ->with('success', 'Feedback berhasil dikirim.');
    }

    public function index_pembimbing($id){
        $prodi_id = session('prodi_id');
        $KPA_id = session('KPA_id');
        $TM_id = session('TM_id');
        $user_id = session('user_id');

        $artefak = pengumpulan_tugas::with(['kelompok.pembimbing','tugas'])
            ->where('tugas_id', $id)// ambil berdasarkan tugas_id = $id
            ->whereHas('kelompok',function ($query) use ($user_id){
                $query->whereHas('pembimbing', function ($q ) use ($user_id){
                    $q->where('user_id',$user_id);

                });
            }) 
            ->whereHas('tugas', function ($query) use ($prodi_id, $KPA_id, $TM_id) {
                $query->where('prodi_id', $prodi_id)
                      ->where('KPA_id', $KPA_id)
                      ->where('TM_id', $TM_id);
            })
            ->get();
        return view('pages.pembimbing.tugas.show_submission', compact('artefak'));
    }
}
