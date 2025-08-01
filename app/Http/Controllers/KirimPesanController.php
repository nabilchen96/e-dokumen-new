<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Profil;
use App\Models\KirimPesan;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Jobs\KirimPesanJob;


class KirimPesanController extends Controller
{
    public function index(){

        $id = Request('id_skpd');
        $skpd = DB::table('skpds')->where('id', $id)->first();
        $data = DB::table('profils')
                ->leftjoin('users', 'users.id', '=', 'profils.id_user')
                ->select(
                    'users.name', 
                    'profils.nip',
                    'users.no_wa',
                    'profils.instansi_kerja',
                    'profils.satuan_kerja',
                    'users.id'
                )
                ->whereIn('status_pegawai', ['PNS', 'P3K'])
                ->where('instansi_kerja', $skpd->nama_skpd)
                ->get();

        return view('backend.kirim_pesan.index', [
            'data'  => $data, 
            'skpd'  => $skpd
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|array',
            'pesan' => 'required|string'
        ]);

        $pesanText = $request->pesan;

        foreach ($request->id_user as $index => $id) {
            $user = User::find($id);

            if ($user) {
                $pesan = KirimPesan::create([
                    'nomor_pesan' => strtoupper(Str::random(10)),
                    'pesan' => $pesanText,
                    'nomor_tujuan' => $user->no_wa,
                    'id_user' => $user->id,
                    'id_pengirim' => Auth::id(),
                    'status' => 'pending',
                ]);

                // Dispatch job dengan delay per 10 detik
                KirimPesanJob::dispatch()->delay(now()->addSeconds(10));
            }
        }

        return back()->with('success', 'Pesan sedang dikirim bertahap.');
    }

    public function history(){

        $id = Request('id_skpd');
        $skpd = DB::table('skpds')->where('id', $id)->first();
        $data = DB::table('kirim_pesans')
                ->leftjoin('users', 'users.id', '=', 'kirim_pesans.id_user')
                ->select(
                    'kirim_pesans.*',
                    'users.name', 
                    'users.no_wa'
                )->get();

        return view('backend.kirim_pesan.history', [
            'data'  => $data,
            'skpd' => $skpd
        ]);
    }
}
