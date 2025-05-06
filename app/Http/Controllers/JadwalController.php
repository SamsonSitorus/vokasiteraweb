<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Models\Jadwal;
use App\Models\Kelompok;
use App\Models\KategoriPA;
use App\Models\Prodi;
use App\Models\DosenRole;
use App\Models\TahunMasuk;
use App\Models\Ruangan;
use App\Models\Role;
use App\Models\PengajuanSeminar;
use Exception;


class JadwalController extends Controller
{
    public function index(Request $request)
    {
        try {
            $userID = session('user_id');
            if (!$userID) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }
    
            $jadwal = Jadwal::with(['kelompok.pembimbing', 'kelompok.penguji'])
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
                // Set Nama Pembimbing
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
    
                // Set Nama Penguji
                if ($item->kelompok && $item->kelompok->penguji->isNotEmpty()) {
                    $pengujiNames = [];
                    foreach ($item->kelompok->penguji as $penguji) {
                        $namaPenguji = $dosenArray[$penguji->user_id] ?? 'Tidak Ditemukan';
                        $pengujiNames[] = $namaPenguji;
                    }
                    $item->penguji_nama = implode('<br>', $pengujiNames);
                } else {
                    $item->penguji_nama = '-';
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
        $TM_id = session('TM_id');
        $role_id = session('role_id');

        if (!$userID || !$token) {
            return redirect()->route('login')->with('error', 'Sesi telah berakhir');
        }

        // Only show groups that have approved seminar submissions
        $kelompok = Kelompok::where('KPA_id', $KPA_id)
            ->where('prodi_id', $prodi_id)
            ->where('TM_id', $TM_id)
            ->whereHas('pengajuanSeminar', function($query) {
                $query->where('status', 'disetujui');
            })
            ->whereDoesntHave('jadwal') // Ensure no schedule exists yet
            ->get();
            $kategoriPA = kategoriPA::find($KPA_id);
            $prodi = Prodi::find($prodi_id);
            $tahunMasuk = TahunMasuk::find($TM_id);
            $ruangan = Ruangan::all();
            if ($kelompok->isEmpty()) {
                return redirect()->route('jadwal.index')
                    ->with('warning', 'Tidak ada kelompok dengan pengajuan seminar yang disetujui atau semua kelompok sudah memiliki jadwal');
            }
        } catch (Exception $e) {
                Log::error('Error loading create form: ' . $e->getMessage());
                return back()->with('error', 'Gagal memuat form');
        }
        return view('pages.Koordinator.jadwal.create', compact('kelompok','kategoriPA','prodi','tahunMasuk', 'ruangan'));
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
                // Check if schedule already exists
                if (Jadwal::where('kelompok_id', $value)
                    ->where('KPA_id', $request->KPA_id)
                    ->where('prodi_id', $request->prodi_id)
                    ->where('TM_id', $request->TM_id)
                    ->exists()) {
                    $fail('Jadwal untuk kelompok ini sudah ada.');
                }
                $validated = $request->validate([
                'kelompok_id' => ['required', function($attribute, $value, $fail) use($request) {
                    if (Jadwal::where('kelompok_id', $value)
                        ->where('KPA_id', $request->KPA_id)
                        ->where('prodi_id', $request->prodi_id)
                        ->where('TM_id', $request->TM_id)
                        ->exists()) {
                        $fail('Jadwal untuk kelompok ini sudah ada.');
                    }
                }],
                'waktu' => 'required|date|after:now',
                'KPA_id' => 'required|exists:kategori_pa,id',
                'ruangan_id' => 'required|exists:ruangan,id',
                'prodi_id' => 'required|exists:prodi,id',
                'TM_id' => 'required|exists:tahun_masuk,id',
             ]);

             Jadwal::create([
                 'kelompok_id' => $validated['kelompok_id'],
                 'ruangan_id' => $validated['ruangan_id'],
                 'waktu' => $validated['waktu'],
                 'user_id' => $userID,
                 'KPA_id' => $validated['KPA_id'],
                 'prodi_id' => $validated['prodi_id'],
                 'TM_id' => $validated['TM_id'],
                 'created_at' => now(),
                 'updated_at' => now()
             ]);

                // Check if group has approved seminar submission
                $hasApprovedSubmission = PengajuanSeminar::where('kelompok_id', $value)
                    ->where('status', 'disetujui')
                    ->exists();

                if (!$hasApprovedSubmission) {
                    $fail('Kelompok ini belum memiliki pengajuan seminar yang disetujui.');
                }
            }],
            'ruangan' => 'required|string|max:50',
            'waktu' => 'required|date|after:now',
            'KPA_id' => 'required|exists:kategori_pa,id',
            'prodi_id' => 'required|exists:prodi,id',
            'TM_id' => 'required|exists:tahun_masuk,id',
        ]);

        Jadwal::create([
            'kelompok_id' => $validated['kelompok_id'],
            'ruangan' => $validated['ruangan'],
            'waktu' => $validated['waktu'],
            'user_id' => $userID,
            'KPA_id' => $validated['KPA_id'],
            'prodi_id' => $validated['prodi_id'],
            'TM_id' => $validated['TM_id'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Optionally update the seminar submission status to 'terjadwal'
        PengajuanSeminar::where('kelompok_id', $validated['kelompok_id'])
            ->where('status', 'disetujui')
            ->update(['status' => 'terjadwal']);

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
            $ruangan = Ruangan::all();
            $responseDosen = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

            $dosen = collect($responseDosen->json()['data']['dosen'] ?? []);

            $role = Role::all();

            return view('pages.Koordinator.jadwal.edit', compact('jadwal', 'kelompok', 'dosen', 'role','ruangan'));

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
                'ruangan_id' => 'required|exists:ruangan,id',
                'waktu' => 'required|date|after:now',
            ]);

            $jadwal = Jadwal::findOrFail($id);
            $jadwal->update(array_merge($validated, [
                'user_id' => session('user_id'),
                'updated_at' => now()
            ]));

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

        $jadwal = Jadwal::with(['prodi', 'tahunMasuk', 'ruangan','kategoriPA', 'kelompok.penguji', 'kelompok.pembimbing'])
            ->findOrFail($id);

        $token = session('token');
        $responseDosen = Http::withHeaders([
            'Authorization' => "Bearer $token"
        ])->get(env('API_URL') . "library-api/dosen", ['limit' => 100]);

        $dosen = collect($responseDosen->json()['data']['dosen'] ?? []);

        $pembimbingNames = [];
        if ($jadwal->kelompok && $jadwal->kelompok->pembimbing) {
            foreach ($jadwal->kelompok->pembimbing as $pembimbing) {
                $namaPembimbing = $dosen->firstWhere('user_id', $pembimbing->user_id)['nama'] ?? 'Tidak Ditemukan';
                $pembimbingNames[] = $namaPembimbing;
            }
        }

        $pengujiNama = [];
        if ($jadwal->kelompok && $jadwal->kelompok->penguji) {
            foreach ($jadwal->kelompok->penguji as $penguji) {
                $nama = $dosen->firstWhere('user_id', $penguji->user_id)['nama'] ?? '-';
                $pengujiNama[] = $nama;
            }
        }

        return view('pages.Koordinator.jadwal.show', compact('jadwal', 'pengujiNama', 'pembimbingNames'));
    } catch (Exception $e) {
        Log::error('Error showing jadwal: ' . $e->getMessage());
        return back()->with('error', 'Gagal memuat detail jadwal.');
    }
}



    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $jadwal = Jadwal::findOrFail($id);
            $jadwal->delete();

            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');

        } catch (Exception $e) {
            Log::error('Error deleting jadwal: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus jadwal');
        }
    }
}
