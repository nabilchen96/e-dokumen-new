<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\District;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
{
    public function index()
    {
        return view('backend.district.index');
    }

    public function data()
    {

        $data = DB::table('districts')
            ->leftJoin('regencies', 'regencies.id', '=', 'districts.regency_id')
            ->leftJoin('provinces', 'provinces.id', '=', 'regencies.province_id')
            ->select(
                'provinces.name as provinsi_name',
                'regencies.name as regensi_name',
                'districts.*'
            )
            ->get();

        return response()->json(['data' => $data]);
    }

    public function searchDistrict(Request $request)
    {
        $search = $request->input('q'); // Nilai pencarian

        // // Query untuk mengambil data yang sesuai
        // $results = YourModel::where('name', 'LIKE', "%$search%")
        //     ->select('id', 'name') // Pilih kolom yang diperlukan
        //     ->get();

        // // Return JSON ke Select2
        // return response()->json($results);

        $results = DB::table('districts')
            ->leftJoin('regencies', 'regencies.id', '=', 'districts.regency_id')
            ->leftJoin('provinces', 'provinces.id', '=', 'regencies.province_id')
            ->where('districts.name', 'LIKE', "%$search%")
            ->orwhere('provinces.name', 'LIKE', "%$search%")
            ->orwhere('regencies.name', 'LIKE', "%$search%")
            ->select(
                'provinces.name as provinsi_name',
                'regencies.name as regensi_name',
                'districts.*'
            )
            ->get();

        return response()->json($results);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'district' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            $data = District::create([
                'district' => $request->district,
                'status' => $request->status,
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
            'district' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $user = District::find($request->id);
            $data = $user->update([
                'district' => $request->district,
                'status' => $request->status,
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

        $data = District::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
