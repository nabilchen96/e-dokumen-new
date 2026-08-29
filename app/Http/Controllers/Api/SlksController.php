<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Profil;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\File;

class SlksController extends Controller
{
    public function index(){

        // dd(Request('param'));

        $today = Carbon::now();

        // Ambil semua data pegawai beserta user-nya
        $profils = DB::table('profils')
            ->join('users', 'users.id', '=', 'profils.id_user')
            ->select(
                'users.name',
                'profils.nip',
                'profils.tmt_cpns',
                DB::raw('TIMESTAMPDIFF(YEAR, profils.tmt_cpns, CURDATE()) as masa_kerja'),
                'profils.instansi_kerja',
                'profils.satuan_kerja',
                'profils.id as id_profil',
                'profils.tanda_jasa_10',
                'profils.tanda_jasa_20',
                'profils.tanda_jasa_30',
                'profils.sertifikat_slks_10',
                'profils.sertifikat_slks_20',
                'profils.sertifikat_slks_30'
            )
            ->where('nip', $_GET['nip'])
            ->whereNotNull('profils.tmt_cpns')->get();


        // Proses data untuk menambah baris sesuai masa kerja
        $result = collect();

        foreach ($profils as $p) {
            $tahun = $p->masa_kerja;

            if ($tahun >= 10) {
                $result->push([
                    'name' => $p->name,
                    'nip' => $p->nip,
                    'tmt_cpns' => $p->tmt_cpns,
                    'masa_kerja' => 10,
                    'instansi_kerja' => $p->instansi_kerja,
                    'unit_kerja' => $p->satuan_kerja,
                    'id_profil' => $p->id_profil,
                    'tanda_jasa_10' => $p->tanda_jasa_10,
                    'tanda_jasa_20' => $p->tanda_jasa_20,
                    'tanda_jasa_30' => $p->tanda_jasa_30,
                    'sertifikat_slks_10' => $p->sertifikat_slks_10,
                    'sertifikat_slks_20' => $p->sertifikat_slks_20,
                    'sertifikat_slks_30' => $p->sertifikat_slks_30, 
                ]);
            }
            if ($tahun >= 20) {
                $result->push([
                    'name' => $p->name,
                    'nip' => $p->nip,
                    'tmt_cpns' => $p->tmt_cpns,
                    'masa_kerja' => 20,
                    'instansi_kerja' => $p->instansi_kerja,
                    'unit_kerja' => $p->satuan_kerja,
                    'id_profil' => $p->id_profil,
                    'tanda_jasa_10' => $p->tanda_jasa_10,
                    'tanda_jasa_20' => $p->tanda_jasa_20,
                    'tanda_jasa_30' => $p->tanda_jasa_30,
                    'sertifikat_slks_10' => $p->sertifikat_slks_10,
                    'sertifikat_slks_20' => $p->sertifikat_slks_20,
                    'sertifikat_slks_30' => $p->sertifikat_slks_30, 
                ]);
            }
            if ($tahun >= 30) {
                $result->push([
                    'name' => $p->name,
                    'nip' => $p->nip,
                    'tmt_cpns' => $p->tmt_cpns,
                    'masa_kerja' => 30,
                    'instansi_kerja' => $p->instansi_kerja,
                    'unit_kerja' => $p->satuan_kerja,
                    'id_profil' => $p->id_profil,
                    'tanda_jasa_10' => $p->tanda_jasa_10,
                    'tanda_jasa_20' => $p->tanda_jasa_20,
                    'tanda_jasa_30' => $p->tanda_jasa_30,
                    'sertifikat_slks_10' => $p->sertifikat_slks_10,
                    'sertifikat_slks_20' => $p->sertifikat_slks_20,
                    'sertifikat_slks_30' => $p->sertifikat_slks_30, 
                ]);
            }
        }

        // 🔢 Urutkan hasil
        $result = $result->sortBy(['name', 'masa_kerja'])->values();

        return response()->json($result, 200);
    }
}
