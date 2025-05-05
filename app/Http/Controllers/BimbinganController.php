<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Crypt;

class BimbinganController extends Controller
{
    public function index(Request $request){
        $kelompokId = session('kelompok_id');
        // dd($kelompokId);
        $bimbingan = Bimbingan::where ('kelompok_id',$kelompokId)->with('kelompok')->get();

        foreach($bimbingan as $bimbinganItem){
            if($bimbinganItem->rencana_selesai <=now() && $bimbinganItem->status !=='selesai'){
                $bimbinganItem->status = 'selesai';
                $bimbinganItem->save();
            }
        }

        return view('pages.Mahasiswa.Bimbingan.index',compact('bimbingan'));
    }
    public function create() {
        $kelompokId =  session('kelompok_id');
        $token = session('token');

        return view('pages.Mahasiswa.Bimbingan.create',compact('kelompokId'));
        // dd($kelompokId);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'kelompok_id' => 'required||exists:kelompok,id',
            'lokasi' => 'required|string|max:100',
            'keperluan' => 'required|string|max:1000',
            'rencana_mulai' => 'required|date|after_or_equal:today',
            'rencana_selesai' => 'required|date|after_or_equal:today',
            'status' => 'required',
        ]);
    
            Bimbingan::create($validated);
            return redirect()->route('bimbingan.index')->with('success', 'Request Bimbingan  berhasil disimpan.');
    }

    public function edit ($encryptedId){
        try{
            $id = Crypt::decrypt($encryptedId);

            $bimbingan = Bimbingan::findOrFail($id);


            if(in_array($bimbingan->status,['selesai', 'disetujui','ditolak'])){
                   // Tampilkan pesan kesalahan jika status masih Aktif
        return back()->withErrors([
            'error' => 'Tidak dapat mengedit  data Request Bimbingan .',
        ]);
            }
        
                return view('pages.Mahasiswa.Bimbingan.edit',compact('bimbingan'));
                // dd($kelompokId);          
        
    } catch (Exception $e) {
        return redirect()->back()->with('error', 'Gagal menampilkan data: ' . $e->getMessage());
    }
    }

    public function update(Request $request, $encryptedId){
        $id = Crypt::decrypt($encryptedId);

        $validated = $request->validate([
            'lokasi' => 'required|string|max:100',
            'keperluan' => 'required|string|max:1000',
            'rencana_mulai' => 'required|date|after_or_equal:today',
            'rencana_selesai' => 'required|date|after_or_equal:today',
        ]);

        $bimbingan = Bimbingan::findOrFail($id);

        $bimbingan->update($validated);
        return redirect()->route('bimbingan.index')->with('success', 'Tugas berhasil diperbarui!');

    }
    public function destroy ($id){
        try{
        $bimbingan = Bimbingan::find($id);
        if(in_array($bimbingan->status,['selesai', 'disetujui','ditolak'])){
            // Tampilkan pesan kesalahan jika status masih Aktif
 return back()->withErrors([
     'error' => 'Tidak dapat menghapus  data Request Bimbingan .',
 ]);
     }
        $bimbingan->delete();
        return redirect()->back()->with('success', 'Data Request Bimbingan berhasil dihapus.');
      } catch (Exception $e) {
          return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
      }
    }


    //untuk dosen pembimbing

    public function indexpembimbing(){
        $prodi_id = session('prodi_id');
        $KPA_id = session('KPA_id');
        $TM_id = session('TM_id');
        

        $bimbingan = Bimbingan::whereHas('kelompok',function($query) use ($prodi_id,$KPA_id,$TM_id){
            $query  ->where('prodi_id', $prodi_id)
                    ->where('KPA_id', $KPA_id)
                    ->where('TM_id', $TM_id);
        })->with('kelompok')->get();
        
        foreach($bimbingan as $bimbinganItem){
            if($bimbinganItem->rencana_selesai <=now() && $bimbinganItem->status !=='selesai'){
                $bimbinganItem->status = 'selesai';
                $bimbinganItem->save();
            }
        }
        return view('pages.Pembimbing.Bimbingan.index',compact('bimbingan'));
    
    }

    public function setuju($encryptedId){
        $id = Crypt::decrypt($encryptedId); 
       
        $bimbingan = Bimbingan::find($id);
        $userId = session('user_id');
        // dd($userId);
        $bimbingan->status = 'disetujui';
        $bimbingan->user_id = $userId;
        $bimbingan->save();
        return redirect()->back()->with('success', 'Bimbingan berhasil disetujui.');

    }
    public function tolak($encryptedId){
        $id = Crypt::decrypt($encryptedId); 
        $bimbingan = Bimbingan::find($id);
        $userId = session('user_id');
        // dd($userId);
        $bimbingan->status = 'ditolak';
        $bimbingan->user_id = $userId;
        $bimbingan->save();
        return redirect()->back()->with('success', 'Bimbingan berhasil ditolak.');

    }
}
