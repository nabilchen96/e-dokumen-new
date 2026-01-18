<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;

class ScheduleController extends Controller
{
    public function index(){

        $token = cache('api_token');

        if (!$token) {
            $login = Http::post('https://www.absensipegawai.my.id/api/login', [
                'email'    => Auth::user()->email,
                'password' => 'default123'
            ]);

            $token = $login->json()['token'];
            cache(['api_token' => $token], now()->addHours(12));
        }

        $response = Http::withToken($token)
            ->get('https://www.absensipegawai.my.id/api/data-shift');
        $shifts = $response->json();

        return view('backend.schedule.index', [
            'shifts' => $shifts
        ]);
    }

    public function data(Request $request){

        $token = cache('api_token');

        if (!$token) {
            $login = Http::post('https://www.absensipegawai.my.id/api/login', [
                'email'    => Auth::user()->email,
                'password' => 'default123'
            ]);

            $token = $login->json()['token'];
            cache(['api_token' => $token], now()->addHours(12));
        }

        $id_user = $request->id_user;
        $tanggal_dari = $request->tanggal_dari;
        $tanggal_sampai = $request->tanggal_sampai;

        $response = Http::withToken($token)
            ->get('https://www.absensipegawai.my.id/api/data-schedule?id_user='.$id_user.'&tanggal_dari='.$tanggal_dari.'&tanggal_sampai='.$tanggal_sampai);

        return response()->json([
            'data' => $response->json()
        ]);
    }

    public function store(Request $request){

        $token = cache('api_token');

        if (!$token) {
            $login = Http::post('https://www.absensipegawai.my.id/api/login', [
                'email'    => Auth::user()->email,
                'password' => 'default123'
            ]);

            $token = $login->json()['token'];
            cache(['api_token' => $token], now()->addHours(12));
        }

        $response = Http::withToken($token)
            ->post('https://www.absensipegawai.my.id/api/store-schedule', [
                'id_pandu' => $request->id_pandu, 
                'id_shift' => $request->id_shift, 
                'tanggal_dari' => $request->tanggal_dari, 
                'tanggal_ke' => $request->tanggal_ke
        ]);

        $result = $response->json();

         return response()->json([
            'responCode' => 1,
            'respon' => $result['respon'] ?? 'Schedule berhasil ditambahkan'
        ], 200);
    }

    public function update(Request $request){

        $token = cache('api_token');

        if (!$token) {
            $login = Http::post('https://www.absensipegawai.my.id/api/login', [
                'email'    => Auth::user()->email,
                'password' => 'default123'
            ]);

            $token = $login->json()['token'];
            cache(['api_token' => $token], now()->addHours(12));
        }

        $response = Http::withToken($token)
            ->post('https://www.absensipegawai.my.id/api/update-schedule', [
                'id_pandu' => $request->id_pandu, 
                'id_shift' => $request->id_shift, 
                'tanggal_dari' => $request->tanggal_dari, 
                'id' => $request->id
        ]);

        $result = $response->json();

         return response()->json([
            'responCode' => 1,
            'respon' => $result['respon'] ?? 'Schedule berhasil diupdate'
        ], 200);
    }

    public function delete(Request $request){

        $token = cache('api_token');

        if (!$token) {
            $login = Http::post('https://www.absensipegawai.my.id/api/login', [
                'email'    => Auth::user()->email,
                'password' => 'default123'
            ]);

            $token = $login->json()['token'];
            cache(['api_token' => $token], now()->addHours(12));
        }

        $response = Http::withToken($token)
            ->post('https://www.absensipegawai.my.id/api/delete-schedule', [
                'id' => $request->id
        ]);

        $result = $response->json();

         return response()->json([
            'responCode' => 1,
            'respon' => $result['respon'] ?? 'Schedule berhasil dihapus'
        ], 200);
    }
}
