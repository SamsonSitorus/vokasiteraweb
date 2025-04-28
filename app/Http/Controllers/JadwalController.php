<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Models\Jadwal;
use App\Models\Kelompok;
use App\Models\kategoriPA;
use App\Models\Prodi;
use App\Models\DosenRole;
use App\Models\TahunAjaran;
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

            $jadwal = Jadwal::with(['kelompok.pembimbing']) // <= Tambahkan eager loading pembimbing
                ->where('user_id', $userID)
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

                if ($item->kelompok && $item->kelompok->pembimbing->isNotEmpty()) {
                    $pembimbingNames = [];
                    foreach ($item->kelompok->pembimbing as $pembimbing) {
                        $namaPembimbing = $dosenArray[$pembimbing->user_id] ?? 'Tidak Ditemukan';
                        $pembimbingNames[] = $namaPembimbing;
                    }
                    $item->pembimbing_nama = implode(', ', $pembimbingNames);
                } else {
                    $item->pembimbing_nama = '-';
                }
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
            {
            try {
                $userID = session('user_id');
                $token = session('token');
                $KPA_id = session('KPA_id');
                $prodi_id = session('prodi_id');
                $TM_id = session('TM_id');
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
                                    ->where('TM_id', $TM_id)
                                    ->get();

                $role = Role::all();

                return view('pages.Koordinator.jadwal.create', compact('kelompok', 'dosen', 'role'));

            } catch (Exception $e) {
                Log::error('Error loading create form: ' . $e->getMessage());
                return back()->with('error', 'Gagal memuat form');
            }
            // $jadwal = Jadwal::with(['kelompok.pembimbing.dosen'])->get();
            $kategoriPA = KategoriPA::find($KPA_id);
            $prodi = Prodi::find($prodi_id);
            $tahunAjaran = TahunAjaran::find($TA_id);

            $responseDosen = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

            $dosenApiMap = collect();
            if ($responseDosen->successful()) {
                $dosenlist = $responseDosen->json()['data']['dosen'] ?? [];
                $dosenApiMap = collect($dosenlist)->keyBy('user_id');
            }

            $dosen = DosenRole::with(['prodi', 'tahunAjaran', 'kategoripa', 'role'])
                ->where('prodi_id', $prodi_id)
                ->where('KPA_id', $KPA_id)
                ->where('TA_id', $TA_id)
                ->whereHas('role', function ($query) {
                    $query->where('role_name', 'penguji 1');
                })->get();

            $dosenFinal = $dosen->map(function ($dr) use ($dosenApiMap) {
                return [
                    'user_id' => $dr->user_id,
                    'nama' => $dosenApiMap[$dr->user_id]['nama'] ?? 'Nama Tidak Diketahui',
                    'prodi' => $dr->prodi->nama_prodi ?? '',
                    'role' => $dr->role->role_name ?? '',
                    'tahun_ajaran' => $dr->tahunAjaran->tahun ?? '',
                    'kategori' => $dr->kategoripa->nama_kategori ?? '',
                ];
            });

            $kelompok = Kelompok::with('pembimbing')  
                ->where('KPA_id', $KPA_id)
                ->where('prodi_id', $prodi_id)
                ->where('TA_id', $TA_id)
                ->get();

            $role = Role::all();

            return view('pages.Koordinator.jadwal.create', compact(
                'kelompok', 'dosen', 'role', 'dosenFinal',
                'kategoriPA', 'prodi', 'tahunAjaran'
            ));

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
                'kelompok_id' => ['required', function($attribute, $value, $fail) use($request) {
                        $KPA_id = $request->input('KPA_id');
                        $prodi_id = $request->input('prodi_id');
                        $TA_id = $request->input('TA_id');

                        if (Jadwal::where('kelompok_id', $value)
                            ->where('KPA_id', $KPA_id)
                            ->where('prodi_id', $prodi_id)
                            ->where('TA_id', $TA_id)
                            ->exists()) {
                            $fail("Jadwal untuk kelompok ini sudah ada.");
                        }
                    }],
                'ruangan' => 'required|string|max:50',
                'waktu' => 'required|date|after:now',
                'penguji1' => 'required|integer|different:penguji2',
                'penguji2' => 'required|integer|different:penguji1',
                'KPA_id' => 'required|exists:kategori_pa,id',
                'prodi_id' => 'required|exists:prodi,id',
                'TA_id' => 'required|exists:tahun_ajaran,id',
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
                'TA_id' => $validated['TA_id'],
                'prodi_id' => $validated['prodi_id'],
                'KPA_id' => $validated['KPA_id'],
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
            $TM_id = session('TM_id');

            $jadwal = Jadwal::findOrFail($id);

            $kelompok = Kelompok::where('KPA_id', $KPA_id)
                                ->where('prodi_id', $prodi_id)
                                ->where('TM_id', $TM_id)
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

    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $jadwal = Jadwal::findOrFail($id);

            $token = session('token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . 'library-api/dosen', ['limit' => 100]);

            if ($response->successful()) {
                $dosenList = $response->json()['data']['dosen'] ?? [];

                $penguji1 = collect($dosenList)->firstWhere('user_id', $jadwal->penguji1);
                $penguji2 = collect($dosenList)->firstWhere('user_id', $jadwal->penguji2);
            }

            return view('pages.Koordinator.jadwal.show', compact('jadwal', 'penguji1', 'penguji2'));

        } catch (Exception $e) {
            Log::error('Error loading jadwal detail: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat detail jadwal');
        }
    }

    public function destroy($id)
    {
        try {
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