<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Models\Kelompok;
use Carbon\Carbon;
class Artefak_Controller extends Controller
{
    public function index(Request $request)
    {
        $prodi_id = session('prodi_id');
        $KPA_id = session('KPA_id');
        $TA_id = session('TA_id');
    
        $artefak = Tugas::with(['prodi', 'tahunAjaran', 'kategoripa'])
            ->where('prodi_id', $prodi_id)
            ->where('KPA_id', $KPA_id)
            ->where('TA_id', $TA_id)
            ->get();
    
            foreach ($artefak as $item) {
                $deadline = Carbon::parse($item->tanggal_pengumpulan);
                $now = Carbon::now();
                $diffInSeconds = $now->diffInSeconds($deadline, false);
            
                $item->formatted_deadline = $deadline->format('d M Y - h:i A');
            
                if ($diffInSeconds > 0) {
                    // Masih ada waktu
                    if ($diffInSeconds >= 86400) { // lebih dari atau sama dengan 24 jam
                        $days = floor($diffInSeconds / 86400);
                        $item->time_remaining = "$days hari lagi";
                    } else {
                        $hours = floor($diffInSeconds / 3600);
                        $minutes = floor(($diffInSeconds % 3600) / 60);
                        $item->time_remaining = "{$hours} jam {$minutes} menit lagi";
                    }
                    $item->status_class = 'text-warning';
                } else {
                    // Sudah lewat deadline
                    $diffInSeconds = abs($diffInSeconds);
                    if ($diffInSeconds >= 86400) {
                        $days = floor($diffInSeconds / 86400);
                        $item->time_remaining = "Selesai $days hari yang lalu";
                    } else {
                        $hours = floor($diffInSeconds / 3600);
                        $minutes = floor(($diffInSeconds % 3600) / 60);
                        $item->time_remaining = "Selesai {$hours} jam {$minutes} menit yang lalu";
                    }
                    $item->status_class = 'text-success';
                }
            }
    
        return view('pages.Mahasiswa.Artefak.index', compact('artefak'));
    }
    
}
