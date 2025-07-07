<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\LaporMasalah;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LaporMasalahController extends Controller
{
    public function index()
    {
        return view('backend.lapor_masalah.index');
    }

    public function data()
    {

        $data = DB::table('lapor_masalahs');

        if(Auth::user()->role == 'Admin'){
            $data = $data->get();
        }else{
            $data = $data->where('id_user', Auth::id())->get();
        }

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'masalah' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            //lapor_masalah
            if ($request->gambar) {
                $gambar = time() . '.' . $request->gambar->extension();
                $request->gambar->move(public_path('lapor_masalah'), $gambar);
            }

            $data = LaporMasalah::create([
                'masalah' => $request->masalah,
                'gambar' => $gambar,
                'id_user' => Auth::id(),
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
            'masalah' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //lapor_masalah
            if ($request->gambar) {
                $gambar = time() . '.' . $request->gambar->extension();
                $request->gambar->move(public_path('lapor_masalah'), $gambar);
            }

            $user = LaporMasalah::find($request->id);
            $data = $user->update([
                'jawaban' => $request->jawaban, 
                'status'  => $request->status
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

        $data = LaporMasalah::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
