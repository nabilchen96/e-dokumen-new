<?php

namespace App\Http\Controllers;

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

        return view('backend.slks.index');
    }

    public function data(){

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
<<<<<<< HEAD
                'profils.tanda_jasa_30'
=======
                'profils.tanda_jasa_30',
                'profils.sertifikat_slks_10',
                'profils.sertifikat_slks_20',
                'profils.sertifikat_slks_30'
>>>>>>> 2b7d42f7fa55ec18e49bb17faeb4cb7fedd0eea0
            )
            ->whereNotNull('profils.tmt_cpns');

            if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Kepala BKPSDM') {

                $profils = $profils->get();

            } elseif (Auth::user()->role == 'Pegawai') {

                $profils = $profils->where('profils.id_user', Auth::id())->get();

            } elseif (Auth::user()->role == 'SKPD'){

                // $profils = $profils->where('dokumens.id_skpd', Auth::user()->id_skpd)->get();
                $profils = $profils->join('skpds as uk_filter', 'uk_filter.nama_skpd', '=', 'profils.instansi_kerja')
                                ->where('uk_filter.id', Auth::user()->id_skpd)->get();

            } elseif (Auth::user()->role == 'OPD' && Auth::user()->id_unit_kerja){

                // $profils = $profils->where('dokumens.id_unit_kerja', Auth::user()->id_unit_kerja)->get();
                $profils = $profils->join('unit_kerjas as uk_filter', 'uk_filter.unit_kerja', '=', 'profils.satuan_kerja')
                                ->where('uk_filter.id', Auth::user()->id_unit_kerja)->get();
            }

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

        // 🔍 Filterisasi berdasarkan parameter (param)
        $param = (int) Request('param');

        if ($param == 2) {
            $result = $result->where('masa_kerja', 10);
        } elseif ($param == 3) {
            $result = $result->where('masa_kerja', 20);
        } elseif ($param == 4) {
            $result = $result->where('masa_kerja', 30);
        }
        // Jika param 0 atau 1 → tampilkan semua (tanpa filter)

        // 🔢 Urutkan hasil
        $result = $result->sortBy(['name', 'masa_kerja'])->values();

        return response()->json(['data' => $result]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_profil' => 'required',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png',
            'masa_kerja' => 'required',
            'type' => 'required|in:persyaratan,sertifikat'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'responCode' => 0,
                'respon' => $validator->errors()
<<<<<<< HEAD
            ];

        } else {

            // ✅ Ambil profil berdasarkan id_profil
            $profil = Profil::find($request->id_profil);
            if (!$profil || !$profil->tmt_cpns) {
                return response()->json([
                    'responCode' => 0,
                    'respon' => 'Profil atau tanggal TMT CPNS tidak ditemukan'
                ]);
            }

            // Hitung masa kerja (dalam tahun)
            // $masaKerja = Carbon::parse($profil->tmt_cpns)->diffInYears(Carbon::now());
            
            // Tentukan level dokumen
            if ($request->masa_kerja >= '30 Tahun') {
                $level = 30;
                $kolom = 'tanda_jasa_30';
            } elseif ($request->masa_kerja >= '20 Tahun') {
                $level = 20;
                $kolom = 'tanda_jasa_20';
            } elseif ($request->masa_kerja >= '10 Tahun') {
                $level = 10;
                $kolom = 'tanda_jasa_10';
            } else {
                $level = null;
            }

            // Jika ada file di-upload
            if ($request->hasFile('dokumen') && $level) {

                $file = $request->file('dokumen');

                // Nama file unik dan rapi
                $filename = $level .  time() . '.' . $file->getClientOriginalExtension();

                // Path folder tujuan di dalam public/
                $destinationPath = public_path("tanda_jasa/{$level}_tahun");
               

                // Buat folder kalau belum ada
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Pindahkan file ke folder public
                $file->move($destinationPath, $filename);

                // Simpan path relatif ke database
                $profil->$kolom = "{$filename}";
                $profil->save();
            }

            return response()->json([
                'responCode' => 1,
                'respon' => "Dokumen Persyaratan SLKS {$level} tahun berhasil diunggah!"
=======
>>>>>>> 2b7d42f7fa55ec18e49bb17faeb4cb7fedd0eea0
            ]);
        }

        // Ambil profil
        $profil = Profil::find($request->id_profil);
        if (!$profil || !$profil->tmt_cpns) {
            return response()->json([
                'responCode' => 0,
                'respon' => 'Profil atau tanggal TMT CPNS tidak ditemukan'
            ]);
        }

        // ===== Tentukan level masa kerja =====
        if ($request->masa_kerja >= '30 Tahun') {
            $level = 30;
        } elseif ($request->masa_kerja >= '20 Tahun') {
            $level = 20;
        } elseif ($request->masa_kerja >= '10 Tahun') {
            $level = 10;
        } else {
            return response()->json([
                'responCode' => 0,
                'respon' => 'Masa kerja tidak masuk kategori 10/20/30 tahun'
            ]);
        }

        // ===== Tentukan kolom berdasarkan TYPE =====
        if ($request->type == 'persyaratan') {
            $kolom = "tanda_jasa_{$level}";
            $folder = "tanda_jasa/{$level}_tahun";
        } else {
            $kolom = "sertifikat_slks_{$level}";
            $folder = "sertifikat_slks/{$level}_tahun";
        }

        // ===== Upload File =====
        if ($request->hasFile('dokumen')) {

            $file = $request->file('dokumen');
            $filename = $level . "" . time() . "." . $file->getClientOriginalExtension();

            // Buat folder jika belum ada
            $destinationPath = public_path($folder);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Pindahkan file
            $file->move($destinationPath, $filename);

            // Simpan ke database
            $profil->$kolom = $filename;
            $profil->save();
        }

        return response()->json([
            'responCode' => 1,
            'respon' => "Dokumen {$request->type} level {$level} tahun berhasil diunggah!"
        ]);
    }

    public function uploadTemplate(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:doc,docx|max:10240', // hanya PDF dan Word
        ]);

        // dd($request->all());

        $file = $request->file('file');
        $fileName = 'Persyaratan_dan_Format_DRH.'.$file->getClientOriginalExtension(); // gunakan nama asli

        $destinationPath = public_path('template_slks');

        // Buat folder jika belum ada
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }

        // Hapus file lama jika sudah ada dengan nama sama
        if (File::exists($destinationPath . '/' . $fileName)) {
            File::delete($destinationPath . '/' . $fileName);
        }

        // Pindahkan file baru
        $file->move($destinationPath, $fileName);

        return back()->with('success', 'File Persyaratan SLKS dan Format DRH berhasil diupload');
    }
}
