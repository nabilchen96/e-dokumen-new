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
                ->leftjoin('unit_kerjas', 'unit_kerjas.id', '=', 'users.id_unit_kerja')
                ->leftjoin('skpds', 'skpds.id', '=', 'users.id_skpd')
                ->select(
                    'users.id',
                    'users.name', 
                    'users.email',
                    'users.role',
                    'users.id_unit_kerja',
                    'unit_kerjas.id_skpd as id_skpd_unit_kerja',
                    'users.id_skpd'
                )
                ->simplePaginate($perPage);

        return response()->json($data, 200);

    }
}
