<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Informasi;
use Auth;
use Illuminate\Support\Facades\Validator;


class InformasiController extends Controller
{
    public function index()
    {
        return view('backend.informasi.index');
    }

    public function data()
    {

        $data = DB::table('informasis');

        if(Auth::user()->role == 'Admin'){
            $data = $data->get();
        }else{
            $data = $data->where('id', 999999999999999)->get();          
        }

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'informasi' => 'required',
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            $data = Informasi::create($request->all());

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
            'informasi' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $user = Informasi::find($request->id);
            $data = $user->update($request->all());

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        $data = Informasi::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
    
}
