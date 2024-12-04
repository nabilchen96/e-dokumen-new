<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Skpd;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SkpdController extends Controller
{
    public function index()
    {
        return view('backend.skpd.index');
    }

    public function data()
    {

        $data = DB::table('skpds')
                // ->join('districts', 'districts.id', '=', 'skpds.district_id')
                // ->join('regencies', 'regencies.id', '=', 'districts.regency_id')
                // ->join('provinces', 'provinces.id', '=', 'regencies.province_id')
                ->select(
                    'skpds.*',
                    // 'provinces.name as province',
                    // 'regencies.name as regency',
                    // 'districts.name as district',
                )
                ->get();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_skpd' => 'required',
            // 'district_id' => 'required',
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            $data = Skpd::create([
                'nama_skpd' => $request->nama_skpd,
                'district_id' => 0,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'email' => $request->email,
                'latitude' => $request->latitude, 
                'longitude' => $request->longitude
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
            'nama_skpd' => 'required',
            // 'district_id' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $user = Skpd::find($request->id);
            $data = $user->update([
                'nama_skpd' => $request->nama_skpd,
                'district_id' => 0,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'email' => $request->email,
                'latitude' => $request->latitude, 
                'longitude' => $request->longitude
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

        $data = Skpd::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
