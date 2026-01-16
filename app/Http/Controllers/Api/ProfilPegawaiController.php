<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ProfilPegawaiController extends Controller
{
    public function index(Request $request){

        $perPage = $request->input('per_page', 10);

        $data = DB::table('users')
                ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
                ->select(
                    'users.id',
                    'users.name', 
                    'users.email',
                    'profils.nip',
                    'profils.jenis_kelamin',
                    'profils.tempat_lahir',
                    'profils.tanggal_lahir',
                    'profils.status_pegawai',
                    'profils.jabatan',
                    'profils.pangkat',
                    'profils.instansi_kerja',
                    'profils.satuan_kerja',

                )
                ->simplePaginate($perPage);

        return response()->json($data, 200);

    }
}
