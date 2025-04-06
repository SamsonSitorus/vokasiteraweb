<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class Dosen_RoleController extends Controller
{
    public function store(Request $request){
       // dd($request->all());
        $request->validate([
            'user_id' =>'required',
            'role_id' =>'required|array',
        ],
        [
            'user_id.required' => 'Dosen tidak boleh kosong',
            'role_id.required' => 'Role tidak boleh Kosong',
        ]);
         $client = new Client();
         $url = env('API_URL2') . "/dosenroles/";

        try {
            foreach ($request->input('role_id') as $role) {
                $response = $client->post($url, [
                    'json' => [
                        'user_id' => intval ($request->input('user_id')),
                        'role_ids' => array_map('intval', $request->input('role_id')),
                    ],
                    'headers' => ['Accept' => 'application/json'],
                    'timeout' => 30,
                    
                ]);
            }
return redirect()->back()->with('success', 'Role dosen berhasil ditambahkan.');

        }catch (RequestException $e) {
            Log::error('RequestException: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghubungkan ke server.'])->withInput();
        } catch (Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan internal.'])->withInput();
        }

    }
}
