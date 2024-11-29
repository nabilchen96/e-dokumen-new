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
                ->select(
                    'dokumens.*',
                    'jenis_dokumens.jenis_dokumen',
                    'users.name'
                )
                ->where('jenis_dokumens.id', Request('jenis_dokumen'))
                ->get();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png'
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            $dokumen = $request->dokumen;
            $nama_dokumen = '1' . date('YmdHis.') . $dokumen->extension();
            $dokumen->move('dokumen', $nama_dokumen);

            $data = Dokumen::create([
                'dokumen' => $nama_dokumen,
                'id_dokumen' => $request->id_dokumen,
                'id_user' => $request->id_user ?? Auth::id(),
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
            'dokumen' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            if($request->dokumen){
                $dokumen = $request->dokumen;
                $nama_dokumen = '1' . date('YmdHis.') . $dokumen->extension();
                $dokumen->move('dokumen', $nama_dokumen);
            }

            $user = Dokumen::find($request->id);
            $data = $user->update([
                'dokumen' => $user->dokumen ?? $nama_dokumen,
                'id_dokumen' => $request->id_dokumen,
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
