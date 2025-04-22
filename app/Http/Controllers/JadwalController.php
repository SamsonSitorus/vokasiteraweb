<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Models\Jadwal;
use App\Models\Kelompok;
use App\Models\Prodi;
use App\Models\Role;
use Exception;
use Carbon\Carbon;

class JadwalController extends Controller
{
   
    public function index(Request $request)
    {
        try {
            $userID = session('user_id');
            if (!$userID) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }

            $jadwal = Jadwal::where('user_id', $userID)
                ->orderBy('created_at', 'desc')
                ->get();

            $token = session('token');
            $responseDosen = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

            $dosenData = $responseDosen->successful() ? $responseDosen->json()['data']['dosen'] : [];

            $dosenArray = [];
            foreach ($dosenData as $dosen) {
                $dosenArray[$dosen['user_id']] = $dosen['nama'];
            }
            foreach ($jadwal as $item) {
                $item->penguji1_nama = $dosenArray[$item->penguji1] ?? 'Tidak Ditemukan';
                $item->penguji2_nama = $dosenArray[$item->penguji2] ?? 'Tidak Ditemukan';
            }

            return view('pages.Koordinator.jadwal.index', compact('jadwal'));

        } catch (Exception $e) {
            Log::error('Error fetching jadwal: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengambil data jadwal');
        }
    }

    public function create()
        {
            try {
                $userID = session('user_id');
                $token = session('token');
                $KPA_id = session('KPA_id');
                $prodi_id = session('prodi_id');
                $TA_id = session('TA_id');
                $role_id = session('role_id');

                if (!$userID || !$token) {
                    return redirect()->route('login')->with('error', 'Sesi telah berakhir');
                }

                $responseDosen = Http::withHeaders([
                    'Authorization' => "Bearer $token"
                ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

                $dosen = $responseDosen->successful() 
                    ? ($responseDosen->json()['data']['dosen'] ?? []) 
                    : [];

                $kelompok = Kelompok::where('KPA_id', $KPA_id)
                                    ->where('prodi_id', $prodi_id)
                                    ->where('TA_id', $TA_id)
                                    ->get();

                $role = Role::all();

                return view('pages.Koordinator.jadwal.create', compact('kelompok', 'dosen', 'role'));

            } catch (Exception $e) {
                Log::error('Error loading create form: ' . $e->getMessage());
                return back()->with('error', 'Gagal memuat form');
            }
        }
    public function store(Request $request)
    {
        try {
            $userID = session('user_id');
            if (!$userID) {
                return redirect()->route('login')->with('error', 'Sesi telah berakhir');
            }

            $validated = $request->validate([
                'kelompok_id' => ['required', function($attribute, $value, $fail) use($request, $userID){
                    if(Jadwal::where('kelompok_id', $value)->where('user_id', $userID)->exists()){
                        $fail("Kamu sudah membuat jadwal untuk kelompok ini.");
                    }
                }],
                'ruangan' => 'required|string|max:50',
                'waktu' => 'required|date|after:now',
                'penguji1' => 'required|integer|different:penguji2',
                'penguji2' => 'required|integer|different:penguji1',
            ], [
                'penguji1.different' => 'Penguji 1 dan Penguji 2 tidak boleh sama.',
                'penguji2.different' => 'Penguji 2 dan Penguji 1 tidak boleh sama.',
            ]);            

            Jadwal::create([
                'kelompok_id' => $validated['kelompok_id'],
                'ruangan' => $validated['ruangan'],
                'waktu' => $validated['waktu'],
                'penguji1' => $validated['penguji1'],
                'penguji2' => $validated['penguji2'],
                'user_id' => $userID,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dibuat');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            Log::error('Error storing jadwal: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan jadwal')->withInput();
        }
    }


    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $token = session('token');
            $KPA_id = session('KPA_id');
            $prodi_id = session('prodi_id');
            $TA_id = session('TA_id');

            $jadwal = Jadwal::findOrFail($id);

            $kelompok = Kelompok::where('KPA_id', $KPA_id)
                                ->where('prodi_id', $prodi_id)
                                ->where('TA_id', $TA_id)
                                ->get();

            $responseDosen = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

            $dosen = $responseDosen->successful() 
                        ? ($responseDosen->json()['data']['dosen'] ?? []) 
                        : [];

            $role = Role::all();

            return view('pages.Koordinator.jadwal.edit', 
                compact('jadwal', 'kelompok', 'dosen', 'role'));

        } catch (Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form edit');
        }
    }

    public function update(Request $request, $id)
    {   
        try {
            $id = Crypt::decrypt($id);
    
            $validated = $request->validate([
                'kelompok_id' => 'required|exists:kelompok,id',
                'ruangan' => 'required|string|max:50',
                'waktu' => 'required|date|after:now',
                'penguji1' => 'required|integer|different:penguji2',
                'penguji2' => 'required|integer|different:penguji1',
            ], [
                'penguji1.different' => 'Penguji 1 dan Penguji 2 tidak boleh sama.',
                'penguji2.different' => 'Penguji 2 dan Penguji 1 tidak boleh sama.',
            ]);
    
            $jadwal = Jadwal::findOrFail($id);
    
            $validated['user_id'] = session('user_id');
            $validated['updated_at'] = now();
    
            $jadwal->update($validated);
    
            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            Log::error('Error updating jadwal: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui jadwal')->withInput();
        }
    }
    

    public function destroy($id)
    {
        try {
            // $id = Crypt::decrypt($id);
            // $userID = session('user_id');

            // if (!$userID) {
            //     return response()->json(['error' => 'Unauthorized'], 401);
            // }

            $jadwal = Jadwal::findOrFail($id);
            $jadwal->delete();

            return redirect()->route('jadwal.index')
                ->with('success', 'Jadwal berhasil dihapus');

        } catch (Exception $e) {
            Log::error('Error deleting jadwal: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus jadwal');
        }

        $tugas->delete();
        return redirect()->back()->with('success','Jadwal berhasil dihapus');
    }
}