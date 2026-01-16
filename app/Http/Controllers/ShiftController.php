<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;


class ShiftController extends Controller
{
    public function index(){
        return view('backend.shift.index');
    }

    public function data(){

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

        return response()->json([
            'data' => $response->json()
        ]);
    }
}
