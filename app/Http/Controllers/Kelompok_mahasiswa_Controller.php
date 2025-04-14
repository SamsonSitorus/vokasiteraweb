    <?php

    namespace App\Http\Controllers;
    use App\Models\Kelompok;
    use App\Models\KelompokMahasiswa;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;

    class Kelompok_mahasiswa_Controller extends Controller
    {public function index($id)
        {
            $token = session('token');
        
            // Ambil data kelompok berdasarkan ID
            $kelompok = Kelompok::findOrFail($id);
        
            // Ambil data mahasiswa yang tergabung dalam kelompok tertentu
            $mahasiswakelompoks = KelompokMahasiswa::where('kelompok_id', $id)->get();
        
            // Ambil data mahasiswa dari API eksternal
            $response = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . "library-api/mahasiswa", [
                'limit' => 100
            ]);
        
            $mahasiswa_map = collect();
        
            if ($response->successful()) {
                $data = $response->json();
                $listMahasiswa = $data['data']['mahasiswa'] ?? [];
        
                // Buat map: user_id => mahasiswa
                $mahasiswa_map = collect($listMahasiswa)->keyBy('user_id');
            }
        
            // Gabungkan data user_id lokal + data dari API
            $mahasiswakelompoks->transform(function ($item) use ($mahasiswa_map) {
                $mhs = $mahasiswa_map->get($item->user_id);
                $item->nama = $mhs['nama'] ?? 'N/A';
                $item->nim = $mhs['nim'] ?? 'N/A';
                return $item;
            });
        
            // Kirim juga $kelompok ke view
            return view('pages.Koordinator.kelompok-mahasiswa.index', compact('mahasiswakelompoks', 'kelompok'));
        }
        
        // public function index($id)
        // {
        //     $token = session('token');
        
        //     // Ambil data mahasiswa yang tergabung dalam kelompok tertentu
        //     $mahasiswakelompoks = KelompokMahasiswa::where('kelompok_id', $id)->get();
        
        //     // Ambil data mahasiswa dari API eksternal
        //     $response = Http::withHeaders([
        //         'Authorization' => "Bearer $token"
        //     ])->get(env('API_URL') . "library-api/mahasiswa", [
        //         'limit' => 100
        //     ]);
        
        //     $mahasiswa_map = collect();
        
        //     if ($response->successful()) {
        //         $data = $response->json();
        //         $listMahasiswa = $data['data']['mahasiswa'] ?? [];
        
        //         // Buat map: user_id => mahasiswa
        //         $mahasiswa_map = collect($listMahasiswa)->keyBy('user_id');
        //     }
        
        //     // Gabungkan data user_id lokal + data dari API
        //     $mahasiswakelompoks->transform(function ($item) use ($mahasiswa_map) {
        //         $mhs = $mahasiswa_map->get($item->user_id);
        //         $item->nama = $mhs['nama'] ?? 'N/A';
        //         $item->nim = $mhs['nim'] ?? 'N/A';
        //         return $item;
        //     });
        
        //     return view('pages.Koordinator.kelompok-mahasiswa.index', compact('mahasiswakelompoks'));
        // }
        public function create($id)
        {
            $token = session('token');
        
            $responseMahasiswa = Http::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get(env('API_URL') . "library-api/mahasiswa", ['limit' => 100]);
        
            $mahasiswa = $responseMahasiswa->successful()
                ? $responseMahasiswa->json()['data']['mahasiswa'] ?? []
                : [];
        
            // Ambil 1 data kelompok berdasarkan ID
            $kelompok = Kelompok::findOrFail($id);
        
            return view('pages.Koordinator.kelompok-mahasiswa.create', compact('mahasiswa', 'kelompok'));
        }
        

        public function store(Request $request)
        {
        $request->validate([
            'user_id' => 'required|numeric',
            'kelompok_id' => 'required|exists:kelompok,id',
        ]);

        // Cek apakah mahasiswa sudah tergabung
        $exists = KelompokMahasiswa::where('user_id', $request->user_id)
            ->where('kelompok_id', $request->kelompok_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Mahasiswa sudah ada di kelompok ini.');
        }

        KelompokMahasiswa::create([
            'user_id' => $request->user_id,
            'kelompok_id' => $request->kelompok_id,
        ]);

        return redirect()->route('kelompokMahasiswa.index', $request->kelompok_id)
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
        }


        public function edit($id)
        {
        $kelompokMahasiswa = KelompokMahasiswa::findOrFail($id);

        // (Opsional) Ambil data mahasiswa dari API eksternal berdasarkan user_id
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => "Bearer $token"
        ])->get(env('API_URL') . "library-api/mahasiswa/{$kelompokMahasiswa->user_id}");

        $mahasiswa = $response->successful() ? $response->json()['data'] : null;

        return view('pages.Koordinator.kelompok-mahasiswa.edit', compact('kelompokMahasiswa', 'mahasiswa'));
        }

        
    }
