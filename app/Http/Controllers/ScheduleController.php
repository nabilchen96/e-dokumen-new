<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;

class ScheduleController extends Controller
{
    public function index(){
        return view('backend.schedule.index');
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
}
