<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Dokumen;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DokumenController extends Controller
{
    public function index()
    {
        return view('backend.dokumen.index');
    }

    public function data()
    {

        $data = DB::table('dokumens')
            ->leftJoin('users', 'users.id', '=', 'dokumens.id_user')
            ->leftJoin('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
            ->leftJoin('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
            ->select(
                'dokumens.*',
                'jenis_dokumens.jenis_dokumen',
                'users.name',
                'skpds.nama_skpd'
            )
            ->where('jenis_dokumens.id', Request('jenis_dokumen'));


        if (Auth::user()->role == 'Admin') {

            $data = $data->get();

        } elseif (Auth::user()->role == 'Pegawai') {

            $data = $data->where('dokumens.id_user', Auth::id())->get();
        }


        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'tanggal_dokumen' => 'required',
        ],[
            'dokumen.file' => 'Dokumen yang diunggah harus berupa file.',
            'dokumen.mimes' => 'Dokumen harus berformat PDF, JPG, atau PNG.',
            'dokumen.max' => 'Ukuran dokumen maksimal adalah 1MB.',
            'tanggal_dokumen.required' => 'Tanggal Awal Dokumen Wajib Diisi',
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            //CEK USER
            $pegawai = DB::table('users')
                ->leftjoin('profils', 'profils.id_user', '=', 'users.id')
                ->where('users.id', $request->id_user ?? Auth::id())
                ->select(
                    'profils.nip',
                    'users.name'
                )
                ->first();


            //CEK SKPD
            $skpd = DB::table('skpds')->where('id', $request->id_skpd)->first();


            $dokumen = $request->dokumen;
            $nama_dokumen = 'NIP_' . $pegawai->nip . '_' . $pegawai->name . '_' . $skpd->nama_skpd . '_' . date('YmdHis') . '.' . $dokumen->extension();
            $dokumen->move('dokumen', $nama_dokumen);

            $data = Dokumen::create([
                'dokumen' => $nama_dokumen,
                'id_dokumen' => $request->id_dokumen,
                'id_user' => $request->id_user ?? Auth::id(),
                'tanggal_dokumen' => $request->tanggal_dokumen,
                'tanggal_akhir_dokumen' => $request->tanggal_akhir_dokumen,
                'id_skpd' => $request->id_skpd
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'dokumen' => 'file|mimes:pdf,jpg,jpeg,png|max:1024',
            'tanggal_dokumen' => 'required',
        ],
        [
            'id.required' => 'Kolom ID wajib diisi.',
            'dokumen.file' => 'Dokumen yang diunggah harus berupa file.',
            'dokumen.mimes' => 'Dokumen harus berformat PDF, JPG, atau PNG.',
            'dokumen.max' => 'Ukuran dokumen maksimal adalah 1MB.',
            'tanggal_dokumen.required' => 'Tanggal Awal Dokumen Wajib Diisi',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //CEK USER
            $pegawai = DB::table('users')
                ->leftjoin('profils', 'profils.id_user', '=', 'users.id')
                ->where('users.id', $request->id_user ?? Auth::id())
                ->select(
                    'profils.nip',
                    'users.name'
                )
                ->first();


            //CEK SKPD
            $skpd = DB::table('skpds')->where('id', $request->id_skpd)->first();

            if ($request->dokumen) {
                $dokumen = $request->dokumen;
                $nama_dokumen = date('YmdHis.') . '_' . $pegawai->nip . '_' . $pegawai->name . '_' . $skpd->nama_skpd . $dokumen->extension();
                $dokumen->move('dokumen', $nama_dokumen);
            }

            $user = Dokumen::find($request->id);
            $data = $user->update([
                'dokumen' => $user->dokumen ?? $nama_dokumen,
                'id_dokumen' => $request->id_dokumen,
                'tanggal_dokumen' => $request->tanggal_dokumen,
                'tanggal_akhir_dokumen' => $request->tanggal_akhir_dokumen,
                'id_skpd' => $request->id_skpd
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function updateStatusDokumen(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $user = Dokumen::find($request->id);
            $data = $user->update([
                'status' => $request->status
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        $data = Dokumen::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
