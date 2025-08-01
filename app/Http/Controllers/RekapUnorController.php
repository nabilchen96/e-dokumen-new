<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RekapUnorController extends Controller
{
    public function index(){
        return view('backend.rekap_unor.index');
    }

    public function data(){

        $profil = DB::table('profils')
                    ->join('skpds', 'profils.instansi_kerja', '=', 'skpds.nama_skpd')
                    ->select(
                        'skpds.id as id_skpd',
                        'profils.instansi_kerja',
                        DB::raw('COUNT(*) as total_pegawai'),
                        DB::raw("SUM(CASE WHEN status_pegawai = 'PNS' THEN 1 ELSE 0 END) as jumlah_pns"),
                        DB::raw("SUM(CASE WHEN status_pegawai = 'P3K' THEN 1 ELSE 0 END) as jumlah_p3k")
                    )
                    ->whereIn('status_pegawai', ['PNS', 'P3K'])
                    ->whereNotNull('instansi_kerja')
                    ->groupBy('skpds.id', 'profils.instansi_kerja') // Group by semua kolom yang di-select (selain agregat)
                    ->orderBy('total_pegawai', 'desc')
                    ->get();

        return response()->json(['data' => $profil]);

    }
}
