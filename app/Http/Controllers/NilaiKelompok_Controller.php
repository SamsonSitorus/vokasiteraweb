<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Nilai_kelompok;
use Illuminate\Http\Request;

class NilaiKelompok_Controller extends Controller
{
    // untuk koordinator
    public function index()
{
    $userId = session('user_id');
    $prodi_id = session('prodi_id');
    $KPA_id = session('KPA_id');
    $TM_id = session('TM_id');

    $kelompok = Kelompok::where('KPA_id', $KPA_id)
        ->where('TM_id', $TM_id)
        ->where('prodi_id', $prodi_id)
        ->get();

    // ambil nilai yang sudah ada
    $nilaiKelompok = Nilai_kelompok::whereIn('kelompok_id', $kelompok->pluck('id'))->get()->keyBy('kelompok_id');
    return view('pages.pembimbing.Nilai_Kelompok.index', compact('kelompok', 'nilaiKelompok', 'userId'));
}
public function store(Request $request){
    $userId= session('user_id');
    $request->validate([
        'kelompok_id' => 'required|exists:kelompok,id',
        'Nilai' => 'required|numeric|min:0|max:100',
        'user_id' => 'required',
    ]);

    Nilai_kelompok::create([
        'kelompok_id' => $request->kelompok_id,
        'Nilai' => $request->Nilai,
        'user_id'=> $userId,
    ]);
    return redirect()->route('NilaiKelompok.index')->with('Succes, Nilai berhasil Disimpan');
}

public function update(Request $request, $id){
    $request->validate([
        'Nilai' => 'required|numeric|min:0|max:100',
    ]);
    $nilai = Nilai_kelompok::findOrFail($id);
    $nilai->update([
        'Nilai' => $request->Nilai,
    ]);
    return redirect()->back()->with('success', 'Nilai berhasil diperbarui.');
}
public function destroy($id)
{
    $nilai = Nilai_kelompok::findOrFail($id);
    $nilai->delete();

    return redirect()->back()->with('success', 'Nilai berhasil dihapus.');
}



}
