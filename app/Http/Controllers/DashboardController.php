<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $id_user = Auth::id();

        $profil = DB::table('profils')->where('id_user', $id_user)->first();

        $userId = Auth::id(); // ID user yang akan dicek

        // Nama tabel profil
        $table = 'profils';

        // Ambil data user berdasarkan ID
        $userProfile = DB::table($table)->where('id_user', $userId)->first();

        if (!$userProfile) {
            // Jika profil tidak ditemukan
            $isiProfil = "Profil tidak ditemukan.";
        } else {
            // Daftar kolom dan label yang ramah pengguna
            $columnLabels = [
                'jenis_kelamin' => 'Jenis Kelamin',
                'tempat_lahir' => 'Tempat Lahir',
                'tanggal_lahir' => 'Tanggal Lahir',
                'alamat' => 'Alamat',
                'status_pegawai' => 'Status Pegawai',
                'nip' => 'NIP',
                'pangkat' => 'Pangkat',
                'jabatan' => 'Jabatan',
                'nik' => 'NIK',
                'id_unit_kerja' => 'Unit Kerja'
            ];

            // Kolom umum yang harus diisi
            $requiredColumns = [
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'status_pegawai',
                'nik',
                'id_unit_kerja'
            ];

            // Kolom tambahan jika status_pegawai bukan Honorer
            $conditionalColumns = ['nip', 'pangkat', 'jabatan'];

            if ($userProfile->status_pegawai !== 'Honorer') {
                $requiredColumns = array_merge($requiredColumns, $conditionalColumns);
            }

            $emptyColumns = [];

            // Cek setiap kolom yang perlu diisi
            foreach ($requiredColumns as $column) {
                if (empty($userProfile->$column)) {
                    $emptyColumns[] = $columnLabels[$column]; // Gunakan label ramah pengguna
                }
            }

            $isiProfil = empty($emptyColumns) ? 0 : implode(', ', $emptyColumns);
        }

        // dd(Auth::user()->role);


        if (Auth::user()->role == 'Pegawai') {
            // dd('tes');
            // Ambil daftar jenis dokumen yang aktif
            $jenisDokumenAktif = DB::table('jenis_dokumens')
                ->where('status', 'Aktif')
                ->where('jenis_pegawai', 'like', '%' . (@$profil->status_pegawai ?? '') . '%')
                ->orwhere('jenis_pegawai', 'Semua')
                ->get(['id', 'jenis_dokumen']); // Ambil ID dan nama jenis dokumen yang aktif

                // dd($jenisDokumenAktif);

            // Ambil dokumen yang sudah diupload oleh pengguna
            $dokumenUploaded = DB::table('dokumens')
                ->where('id_user', $id_user)
                ->pluck('id_dokumen'); // Ambil ID jenis dokumen yang sudah diupload

            // Menyaring jenis dokumen yang belum diupload
            $belumDiupload = $jenisDokumenAktif->filter(function ($item) use ($dokumenUploaded) {
                return !in_array($item->id, $dokumenUploaded->toArray());
            });

            // Jika tidak ada dokumen yang belum diupload
            if ($belumDiupload->isEmpty()) {

                // dd($isiProfil);

                return view('backend.dashboard', [
                    'dokumenBelumDiupload' => null,
                    'isiProfil' => $isiProfil
                ]);
            } else {
                // Ambil nama-nama dokumen yang belum diupload
                $dokumenBelumDiupload = $belumDiupload->pluck('jenis_dokumen')->implode(', ');
                // dd($dokumenBelumDiupload);

            }

        }

        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'SKPD') {

            //total pegawai
            $total_pegawai = DB::table('users')
                            ->join('profils', 'profils.id_user', '=', 'users.id')
                            ->whereNotIn('profils.status_input', ['Import'])
                            ->where('role', 'Pegawai')
                            ->count();

            //jenis dokumen
            $total_jenis_dokumen = DB::table('jenis_dokumens')->where('status', 'Aktif')->count();

            //total dokumen
            $total_dokumen = DB::table('dokumens')->count();

            //sebaran pegawai
            $total_asal_pegawai = DB::table('skpds')
                ->count(); // Hitung jumlah `district_id` yang unik
        }

        $today = now()->toDateString();

        $variations = [
            'dokumen berkala',
            'Dokumen Berkala',
            'Dokumen berkala',
            'dokumen Berkala',
            'DOKUMEN BERKALA',
            'dok. berkala',
            'dok berkala',
            'Dok. Berkala',
            'Dok Berkala',
            'DOK. BERKALA',
            'DOK BERKALA',
            'dokumenberkala',
            'DokumenBerkala',
            'DOKUMENBERKALA',
            'Dokumenberkala',
            'dokumenBerkala',
            'Kenaikan Gaji',
            'Kenaikan gaji',
            'kenaikan Gaji',
            'kenaikangaji',
            'KenaikanGaji',
            'Kenaikangaji',
            'kenaikanGaji',
            'KENAIKAN GAJI',
            'KENAIKANGAJI',
            'SK Gaji Berkala',
        ];

        $kenaikan_gaji = DB::table('dokumens')
            ->join('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
            ->join('users', 'users.id', '=', 'dokumens.id_user')
            ->join('profils', 'profils.id_user', '=', 'users.id')
            ->leftjoin('kenaikan_gajis', 'kenaikan_gajis.id_dokumen', '=', 'dokumens.id')
            ->select(
                'dokumens.tanggal_akhir_dokumen',
                'users.name',
                'profils.nip',
                'profils.id as id_profil',
                'dokumens.id',
                'dokumens.jenis_dokumen_berkala',
                'kenaikan_gajis.id as id_kenaikan_gaji',
                'kenaikan_gajis.status as status_dokumen',
                DB::raw("DATEDIFF(dokumens.tanggal_akhir_dokumen, '$today') as total_hari")
            )
            ->where('dokumens.status', 'Dokumen Diterima')
            ->where(function ($query) {
                $query->where('kenaikan_gajis.status', 'Draft')
                    ->orWhereNull('kenaikan_gajis.status'); // Periksa NULL secara eksplisit
            })
            ->limit(10)
            ->orderByRaw('total_hari ASC');

        if(Auth::user()->role == 'Admin'){
            $kenaikan_gaji = $kenaikan_gaji->get();
        }elseif(Auth::user()->role == 'SKPD'){
            $kenaikan_gaji = $kenaikan_gaji->where('users.id_creator', Auth::id())->get();
        }


        $dokumen_periksa = DB::table('dokumens')
        ->leftJoin('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
        ->leftJoin('users', 'users.id', '=', 'dokumens.id_user')
        ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
        ->select(
            'dokumens.*',
            'jenis_dokumens.jenis_dokumen',
            'users.name',
            'profils.nip'
        )
        ->where(function($query) {
            $query->whereNull('dokumens.status')
                ->orWhere('dokumens.status', 'Sedang Dalam Pengecekan')
                ->orWhere('dokumens.status', 'Perlu Diperbaiki')
                ->orWhere('dokumens.status', 'Belum Diperiksa');
        })
        ->limit(10)
        ->orderBy('dokumens.created_at', 'asc');

        if(Auth::user()->role == 'Admin'){
            $dokumen_periksa = $dokumen_periksa->get();
        }elseif(Auth::user()->role == 'SKPD'){
            $dokumen_periksa = $dokumen_periksa->where('users.id_creator', Auth::id())->get();
        }


        return view('backend.dashboard', [
            'dokumenBelumDiupload' => $dokumenBelumDiupload ?? '',
            'total_pegawai' => $total_pegawai ?? 0,
            'total_jenis_dokumen' => $total_jenis_dokumen ?? 0,
            'total_dokumen' => $total_dokumen ?? 0,
            'total_asal_pegawai' => $total_asal_pegawai ?? 0,
            'kenaikan_gaji' => $kenaikan_gaji,
            'dokumen_periksa' => $dokumen_periksa,
            'isiProfil' => $isiProfil
        ]);
    }

    public function dataPeta()
    {

        $districts = DB::table('dokumens')
            ->join('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
            ->select(
                'skpds.id as id_skpd',
                'skpds.latitude',
                'skpds.longitude',
                'skpds.nama_skpd',
                DB::raw('COUNT(DISTINCT dokumens.id_user) as total_employees')
            )
            ->whereIn('dokumens.id', function ($query) {
                // Select the latest dokumen per user
                $query->selectRaw('MAX(dokumens.id)')
                    ->from('dokumens')
                    ->groupBy('dokumens.id_user');
            })
            ->groupBy('skpds.id')
            ->get();




        return response()->json($districts);

    }
}