<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ProfilPegawaiV2Controller extends Controller
{
    public function index(Request $request){

        $data = DB::table('users')
                ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
                ->where('users.role', 'Pegawai')
                ->where('profils.nip', $_GET['nip'])
                ->select(
                    'users.id',
                    'users.name', 
                    'users.email',
                    'users.role',
                    'profils.*',

                )
                ->first();

        return response()->json($data, 200);

    }
}
