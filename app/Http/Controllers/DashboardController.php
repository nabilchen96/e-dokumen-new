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

        // Ambil daftar jenis dokumen yang aktif
        $jenisDokumenAktif = DB::table('jenis_dokumens')
            ->where('status', 'Aktif')
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
            return view('backend.dashboard');
        } else {
            // Ambil nama-nama dokumen yang belum diupload
            $dokumenBelumDiupload = $belumDiupload->pluck('jenis_dokumen')->implode(', ');
            // dd($dokumenBelumDiupload);
            return view('backend.dashboard', [
                'dokumenBelumDiupload' => $dokumenBelumDiupload
            ]);
        }
    }
}