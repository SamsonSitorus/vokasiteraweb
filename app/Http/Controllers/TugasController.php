<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Models\DosenRole;
use App\Models\Role;
use App\Models\Tugas;
use GuzzleHttp\Client;
use Exception;


class TugasController extends Controller
{
    public function index(Request $request){
        try{
            $userID = session('user_id');
            if (!$userID) {
                return redirect()->back()->withErrors(['error' => 'User tidak ditemukan']);
            }            
            $tugas = Tugas::where('user_id', $userID)->OrderBy('created_at','desc')->get();
        
            return view('pages.Koordinator.tugas.tugas', compact('tugas'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengambil data tugas: ' . $e->getMessage()]);
        }
    }
    public function create()
    {
        $userID = session('user_id');

        if(!$userID){
            return response() ->json(['Error'=>'Pengguna tidak tersedia'], 401);
        }
        return view('pages.Koordinator.tugas.create');
    }

    public function store(Request $request){
        // $token = session('token');
        $userID = session('user_id');
    
        if(!$userID ){
            return response()->json(['error'=>'Pengguna tidak ditemukan'], 401);
        }
    
        $validated = $request->validate([
            'judul' => 'required|string',
            'instruksi'=> 'required|string',
            'file'=>'file|mimes:pdf,doc,docx,zip,rar|max:5120',
            'batas'=>'required|date',
        ]);
    
        try {
            if($request->hasFile("file")){
                $filePath = $request->file('file')->store('tugas', 'public');
            }
    
            $tugas = new Tugas();
            $tugas->judul = $validated['judul'];
            $tugas->instruksi = $validated['instruksi'];
            $tugas->file = $filePath ?? null;
            $tugas->batas = $validated['batas'];
            $tugas->user_id = $userID;
    
            $tugas->save();
    
            return redirect()->route('tugas.tugas')->with('success', 'Tugas berhasil disimpan.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan tugas: ' . $e->getMessage()]);
        }
    }

    public function edit($id){
        $tugas = Tugas::findOrFail($id);
        return view('pages.Koordinator.tugas.edit', compact('tugas'));
    }

    public function update(Request $request, $id){
        $userID = session('user_id');
        if(!$userID ){
            return response()->json(['error'=>'Pengguna tidak ditemukan'], 401);
        }
    
        $validated = $request->validate([
            'judul' => 'required|string',
            'instruksi'=> 'required|string',
            'file'=>'nullable|file|mimes:pdf,doc,docx,zip,rar|max:5120',
            'batas'=>'required|date',
        ]);
    
        $tugas = Tugas::findOrFail($id);
    
        if($request->hasFile('file')){
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('tugas', $fileName, 'public');
            $tugas->file = $filePath;
        }
    
        $tugas->judul = $request->judul;
        $tugas->instruksi = $request->instruksi;
        $tugas->batas = $request->batas;
        $tugas->save();
    
        return redirect()->route('tugas.tugas')->with('success', 'Tugas berhasil diperbarui!');
    }
    

    public function delete($id)
    {
        $tugas = Tugas::findOrFail($id);
        $userID = session('user_id');

        if (!$userID) {
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 401);
        }

        $tugas->delete();
        return redirect()->back()->with('success', 'Tugas berhasil dihapus.');
    }

    public function show($id){
        $tugas = Tugas::findOrFail($id);
        return view('pages.Koordinator.tugas.show', compact('tugas'));
    }
}
