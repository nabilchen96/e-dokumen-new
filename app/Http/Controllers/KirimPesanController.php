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
use App\Jobs\StorePesanJob;


class KirimPesanController extends Controller
{
    public function index(){

        $id = Request('id_skpd');
        if($id){
            $skpd = DB::table('skpds')->where('id', $id)->first();
        }
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
                ->whereIn('status_pegawai', ['PNS', 'P3K']);

        if(@$skpd){
            $data =  $data->where('instansi_kerja', $skpd->nama_skpd)->get();
        }else{
            $data =  $data->whereNotNull('users.name')->get();
        }

        // return response()->json($data);

        return view('backend.kirim_pesan.index', [
            'data'  => $data, 
            'skpd'  => $skpd ?? ''
        ]);
    }

    public function store(Request $request)
    {
        

        // Ambil ID user dari hidden input yang dikirim JS
        $ids = array_filter(explode(',', $request->selected_ids));

        if (empty($ids)) {
            return back()->withErrors(['msg' => 'Tidak ada penerima yang dipilih.']);
        }

         // Dispatch job sekali saja, karena job sudah melakukan looping di handle()
        StorePesanJob::dispatch(
            $ids,             // array user IDs
            $request->pesan,  // pesan yang dikirim
            Auth::id()        // ID pengirim
        );

        return back()->with('success', 'Pesan sedang dikirim secara bertahap di background.');
    }

    public function history(){

        $id = Request('id_skpd');
        if($id){
            $skpd = DB::table('skpds')->where('id', $id)->first();
        }
        $data = DB::table('kirim_pesans')
                ->leftjoin('users', 'users.id', '=', 'kirim_pesans.id_user')
                ->leftjoin('profils', 'profils.id_user', '=', 'users.id')
                ->select(
                    'kirim_pesans.*',
                    'users.name', 
                    'users.no_wa'
                );

        if(@$skpd){
            $data =  $data->where('profils.instansi_kerja', $skpd->nama_skpd)->get();
        }else{
            $data =  $data->whereNotNull('users.name')->get();
        }

        return view('backend.kirim_pesan.history', [
            'data'  => $data,
            'skpd' => $skpd ?? ''
        ]);
    }
}
