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

        if (Auth::user()->role == 'Pegawai') {
            // Ambil daftar jenis dokumen yang aktif
            $jenisDokumenAktif = DB::table('jenis_dokumens')
                ->where('status', 'Aktif')
                ->where('jenis_pegawai', 'like', '%' . (@$profil->status_pegawai ?? '') . '%')
                ->orwhere('jenis_pegawai', 'Semua')
                ->get(['id', 'jenis_dokumen']); // Ambil ID dan nama jenis dokumen yang aktif

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
                // return response()->json(['message' => 'Semua dokumen telah diupload.'], 200);
                return view('backend.dashboard', [
                    'dokumenBelumDiupload' => null,
                ]);
            } else {
                // Ambil nama-nama dokumen yang belum diupload
                $dokumenBelumDiupload = $belumDiupload->pluck('jenis_dokumen')->implode(', ');
                // dd($dokumenBelumDiupload);

            }

        }

        if (Auth::user()->role == 'Admin') {

            //total pegawai
            $total_pegawai = DB::table('users')->where('role', 'Pegawai')->count();

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
            ->orderByRaw('total_hari ASC')
            ->get();

            // dd($kenaikan_gaji);


        $dokumen_periksa = DB::table('dokumens')
            ->join('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
            ->join('users', 'users.id', '=', 'dokumens.id_user')
            ->join('profils', 'profils.id_user', '=', 'users.id')
            ->select(
                'dokumens.*',
                'jenis_dokumens.jenis_dokumen',
                'users.name',
                'profils.nip',
            )
            ->whereNull('dokumens.status')
            ->orwhere('dokumens.status', 'Sedang Dalam Pengecekan')
            ->orWhere('dokumens.status', 'Perlu Diperbaiki')
            ->orWhere('dokumens.status', 'Belum Diperiksa')
            ->orderBy('dokumens.created_at', 'asc')
            ->get();



        return view('backend.dashboard', [
            'dokumenBelumDiupload' => $dokumenBelumDiupload ?? '',
            'total_pegawai' => $total_pegawai ?? 0,
            'total_jenis_dokumen' => $total_jenis_dokumen ?? 0,
            'total_dokumen' => $total_dokumen ?? 0,
            'total_asal_pegawai' => $total_asal_pegawai ?? 0,
            'kenaikan_gaji' => $kenaikan_gaji,
            'dokumen_periksa' => $dokumen_periksa
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