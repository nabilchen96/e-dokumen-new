<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\UnitKerja;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UnitKerjaController extends Controller
{
    public function index()
    {
        return view('backend.unit_kerja.index');
    }

    public function data()
    {

        $data = DB::table('unit_kerjas')
            ->join('skpds', 'skpds.id', '=', 'unit_kerjas.id_skpd')
            ->select(
                'unit_kerjas.*',
                'skpds.nama_skpd',
            )
            ->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_skpd' => 'required',
            'unit_kerja' => 'required'
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            $data = UnitKerja::create([
                'id_skpd' => $request->id_skpd,
                'unit_kerja' => $request->unit_kerja,
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
            'id_skpd' => 'required',
            'unit_kerja' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $user = UnitKerja::find($request->id);
            $data = $user->update([
                'id_skpd' => $request->id_skpd,
                'unit_kerja' => $request->unit_kerja,
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

        $data = UnitKerja::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }

    public function getUnitKerjaBySkpd($id)
    {
        $unitKerja = DB::table('unit_kerjas')->where('id_skpd', $id)->get();
        return response()->json($unitKerja);
    }

}
