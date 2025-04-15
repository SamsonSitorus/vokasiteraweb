<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Models\Jadwal;
use GuzzleHttp\Client;
use Exception;


class JadwalController extends Controller
{
    public function index(Request $request){
        try{
            $userID = session('user_id');
            if(!$userID){
                return redirect()->back()->withErrors(['error'=>'User tidak ditemukan']);
            }
            $jadwal = Jadwal::where('user_id', $userID)->OrderBy('created_at','desc')->get();

            return view('pages.Koordinator.jadwal.index', compact('jadwal'));

        } catch (Exception $e){
            return back()->withErrors(['error'=>'Gagal mengambil data tugas: '.$e->getMessage()]);
        }
    }
    public function create(){
        $userID = session('user_id');

        if(!$userID){
            return response()-> json(['Error'=>'Pengguna tidak ditemukan']);
        }
        return view('pages.Koordinator.jadwal.index');
    }
    public function store(Request $request){
        $userID = session('user_id');

        if(!$userID){
            return response()->json(['error'=>'pengguna tidak ditemukan']);
        }
        $validated = $request->validate([
            'tanggal'=> 'required|datetime',
            'ruangan'=> 'required|string',
            'jam'=>'required|jam',
        ]);
        try{
            $jadwal = new Jadwal();
            $jadwal -> tanggal = $validated['tanggal'];
            $jadwal-> ruangan = $validated['ruangan'];
            $jadwal -> jam = $validated['jam'];
            $jadwal->user_id = $userID;

            $jadwal-> save();
            return redirect()->route('jadwal.index')->with('succes','Jadwal berhasil disimpan');
        } catch (Exception $e){
            return back()->withErrors(['error'=>'Gagal menyimpan data: '. $e->getMessage()]);
        }
    }
    public function edit($id){
        $jadwal = Jadwal::findOrFail($id);
        return view('pages.Koordinator.jadwal.edit', compact('jadwal'));
    }
    public function update(Request $request, $id){
        $userID = session('user_id');
        if(!$userID){
            return response()->json(['error'=>'Pengguna tidak ada']);
        }
        $validated = $request->validate([
            'tanggal'=> 'required|datetime',
            'ruangan'=> 'required|string',
            'jam'=>'required|jam',
        ]);
        $jadwal = Jadwal::findOrFail($id);
        $jadwal -> tanggal = $request->jadwal;
        $jadwal -> ruangan = $request-> ruangan;
        $jadwal -> jam = $request->jam;
        $jadwal->save();

        return redirect()->route('jadwal.index')->with('succes','data berhasil diperbaharui');   
    }
    public function delete($id){
        $jadwal = Jadwal::findOrFail($id);
        $userID = session('user_id');
        
        if (!$userID) {
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 401);
        }

        $tugas->delete();
        return redirect()->back()->with('success','Jadwal berhasil dihapus');
    }
}
