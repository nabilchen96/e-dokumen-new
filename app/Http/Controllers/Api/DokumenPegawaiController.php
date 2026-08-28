<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DokumenPegawaiController extends Controller
{
       public function index(){

        $data = DB::table('dokumens')
                    ->leftJoin('users', 'users.id', '=', 'dokumens.id_user')
                    ->leftJoin('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
                    ->leftJoin('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
                    ->leftJoin('unit_kerjas', 'unit_kerjas.id', '=', 'dokumens.id_unit_kerja')
                    ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
                    ->where('profils.nip', $_GET['nip'])
                    ->select(

                        'dokumens.*',
                        'jenis_dokumens.jenis_dokumen',
                        'users.name',
                        'skpds.nama_skpd',
                        'unit_kerjas.unit_kerja', 
                        'profils.nip'

                    )->get();


            return response()->json($data, 200);
       }
}
