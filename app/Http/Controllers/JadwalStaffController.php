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
use App\Models\DosenRole;
use App\Models\KategoriPA;
use App\Models\TahunMasuk;
use App\Models\Role;
use App\Models\Ruangan;
use Exception;
use Carbon\Carbon;

class JadwalStaffController extends Controller
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
            return view('pages.BAAK.jadwal.index', compact('jadwal'));
        } catch (Exception $e) {
            Log::error('Error fetching jadwal: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengambil data jadwal');
        }
    }
    public function getKelompok(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required|integer|exists:prodi,id',
            'KPA_id' => 'required|integer|exists:kategori_pa,id',
            'TM_id' => 'required|integer|exists:tahun_masuk,id'
        ]);

        try {
            $kelompok = Kelompok::where('prodi_id', $validated['prodi_id'])
                ->where('KPA_id', $validated['KPA_id'])
                ->where('TM_id', $validated['TM_id'])
                ->select('id', 'nomor_kelompok as text')
                ->get();

            return response()->json($kelompok);

        } catch (Exception $e) {
            \Log::error('Error in getKelompok: '.$e->getMessage());
            return response()->json([], 500);
        }
    }
    public function create(){
        try{
            $userID = session('user_id');
            $token = session('token');

            if (!$userID || !$token) {
                return redirect()->route('login')->with('error', 'Sesi telah berakhir');
            }
            $responseDosen = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

            $dosenApiMap = collect();
                if($responseDosen -> successful()){
                    $dosenlist = $responseDosen->json()['data']['dosen']??[];
                    $dosenApiMap = collect($dosenlist)->keyBy('user_id');
                }
            $dosen = DosenRole::with(['role'])
                ->whereHas('role', function ($query) {
                  $query->where('role_name', 'penguji 1');
              })->get();
            $kategori_pa = KategoriPA::all();
            $prodi = Prodi::all();
            $tahun_masuk = TahunMasuk::all();
            $kelompok = Kelompok::all();
            $ruangan = Ruangan::all();
            return view('pages.BAAK.jadwal.create', compact('kategori_pa', 'prodi', 'tahun_masuk', 'kelompok', 'ruangan'));
        } catch (Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form');
        }
    }
    public function store(Request $request){
        try{
            $userID = session('user_id');
            if(!$userID){
                return redirect()->route('login')->with('error', 'Sesi telah berakhir');
            }
            $validated = $request->validate([
                'kelompok_id' => ['required', function($attribute, $value, $fail) use($request) {
                        $KPA_id = $request->input('KPA_id');

                        $prodi_id = $request->input('prodi_id');
                        $TM_id = $request->input('TM_id');

                        if (Jadwal::where('kelompok_id', $value)
                            ->where('KPA_id', $KPA_id)
                            ->where('prodi_id', $prodi_id)
                            ->where('TM_id', $TM_id)
                            ->exists()) {
                            $fail("Jadwal untuk kelompok ini sudah ada.");
                        }
                    }],
                'ruangan_id' => 'required|exists:ruangan,id',
                'waktu' => 'required|date|after:now',
                'KPA_id' => 'required',
                'prodi_id'=>'required',
                'TM_id'=>'required',
            ]);   
            Jadwal::create([
                'kelompok_id' => $validated['kelompok_id'],
                'ruangan_id' => $validated['ruangan_id'],
                'waktu' => $validated['waktu'],
                'user_id' => $userID,
                'KPA_id'=>$validated['KPA_id'],
                'prodi_id'=>$validated['prodi_id'],
                'TM_id' => $validated['TM_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('baak.jadwal.index')->with('success', 'Jadwal berhasil dibuat');
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
            $userID = session('user_id');
            $token = session('token');

            if (!$userID || !$token) {
                return redirect()->route('login')->with('error', 'Sesi telah berakhir');
            }

            $jadwal = Jadwal::findOrFail($id);

            $responseDosen = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

            $dosenApiMap = collect();
            if ($responseDosen->successful()) {
                $dosenList = $responseDosen->json()['data']['dosen'] ?? [];
                $dosenApiMap = collect($dosenList)->keyBy('user_id');
            }

            $kategori_pa = KategoriPA::all();
            $prodi = Prodi::all();
            $tahun_masuk = TahunMasuk::all();
            $kelompok = Kelompok::all();
            $ruangan = Ruangan::all();

            return view('pages.BAAK.jadwal.edit', compact('jadwal', 'kategori_pa', 'prodi', 'tahun_masuk', 'kelompok', 'ruangan'));
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
                'kelompok_id' => 'required',
                'ruangan_id' => 'required|exists:ruangan,id',
                'waktu' => 'required|date|after:now',
                // 'penguji1' => 'required|integer|different:penguji2',
                // 'penguji2' => 'required|integer|different:penguji1',
                // 'KPA_id' => 'required',
                // 'prodi_id' => 'required',
                // 'TA_id' => 'required',
            ]);

            $jadwal = Jadwal::findOrFail($id);

            $jadwal->update([
                'kelompok_id' => $validated['kelompok_id'],
                'ruangan_id' => $validated['ruangan_id'],
                'waktu' => $validated['waktu'],
                // 'penguji1' => $validated['penguji1'],
                // 'penguji2' => $validated['penguji2'],
                // 'KPA_id' => $validated['KPA_id'],
                // 'prodi_id' => $validated['prodi_id'],
                // 'TA_id' => $validated['TA_id'],
                'updated_at' => now()
            ]);

            return redirect()->route('baak.jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            Log::error('Error updating jadwal: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui jadwal')->withInput();
        }
    }
    // public function show($id)
    // {
    //     try {
    //         $id = Crypt::decrypt($id);
    //         $jadwal = Jadwal::findOrFail($id);

    //         $token = session('token');
    //         $response = Http::withHeaders([
    //             'Authorization' => "Bearer $token"
    //         ])->get(env('API_URL') . 'library-api/dosen', ['limit' => 100]);

    //         if ($response->successful()) {
    //             $dosenList = $response->json()['data']['dosen'] ?? [];

    //             $penguji1 = collect($dosenList)->firstWhere('user_id', $jadwal->penguji1);
    //             $penguji2 = collect($dosenList)->firstWhere('user_id', $jadwal->penguji2);
    //         }

    //         return view('pages.BAAK.jadwal.show', compact('jadwal', 'penguji1', 'penguji2'));

    //     } catch (Exception $e) {
    //         Log::error('Error loading jadwal detail: ' . $e->getMessage());
    //         return back()->with('error', 'Gagal memuat detail jadwal');
    //     }
    // }
    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);

            // Ambil jadwal + relasi kelompok -> penguji dan pembimbing
            $jadwal = Jadwal::with(['kelompok.penguji', 'kelompok.pembimbing', 'prodi', 'tahunMasuk', 'kategoriPA'])->findOrFail($id);

            $token = session('token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . 'library-api/dosen', ['limit' => 100]);

            $dosenArray = [];
            if ($response->successful()) {
                $dosenData = $response->json('data.dosen') ?? [];
                foreach ($dosenData as $dosen) {
                    $dosenArray[$dosen['user_id']] = $dosen['nama'];
                }
            }

            // Ambil semua nama penguji
            $pengujiNama = [];
            if ($jadwal->kelompok && $jadwal->kelompok->penguji) {
                foreach ($jadwal->kelompok->penguji as $penguji) {
                    $pengujiNama[] = $dosenArray[$penguji->user_id] ?? 'Nama tidak ditemukan';
                }
            }

            // Ambil semua nama pembimbing
            $pembimbingNames = [];
            if ($jadwal->kelompok && $jadwal->kelompok->pembimbing) {
                foreach ($jadwal->kelompok->pembimbing as $pembimbing) {
                    $pembimbingNames[] = $dosenArray[$pembimbing->user_id] ?? 'Nama tidak ditemukan';
                }
            }

            return view('pages.BAAK.jadwal.show', compact('jadwal', 'pengujiNama', 'pembimbingNames'));

        } catch (\Exception $e) {
            Log::error('Error loading jadwal detail: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat detail jadwal');
        }
    }

    public function destroy($id){
        try{
            $jadwal = Jadwal::findOrFail($id);
            $jadwal->delete();

            return redirect()->route('baak.jadwal.index')
            -> with('success', 'Jadwal berhasil dihapus');
        }catch (Exception $e) {
            Log::error('Error deleting jadwal: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus jadwal');
        }
    }
}
