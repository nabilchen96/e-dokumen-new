<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class NotPegawaiController extends Controller
{
    public function index(Request $request){

        $perPage = $request->input('per_page', 10);

        $data = DB::table('users')
                ->whereNotIn('users.role', ['Pegawai'])
                ->select(
                    'users.id',
                    'users.name', 
                    'users.email',
                    'users.role',
                    'users.id_unit_kerja'
                )
                ->simplePaginate($perPage);

        return response()->json($data, 200);

    }
}
