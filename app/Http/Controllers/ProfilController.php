<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Profil;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function index()
    {
        return view('backend.profil.index');
    }

    public function data()
    {

        $profil = DB::table('users')
            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
            ->leftJoin('districts', 'districts.id', '=', 'profils.district_id')
            ->whereNotIn('users.role', ['Admin'])
            ->select(
                'users.name',
                'users.email',
                'users.no_wa',
                'users.role',
                'profils.*',
                'districts.name as district',
                'districts.latitude',
                'districts.longitude',
            );

        if (Auth::user()->role == 'Admin') {
            $profil = $profil->get();
        } else {
            $profil = $profil->where('users.id', Auth::id())->get();
        }


        return response()->json(['data' => $profil]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'email' => 'unique:users',
            'no_wa' => 'unique:users',
            'status_pegawai' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = Profil::create([
                'name' => $request->name,
                'role' => $request->role,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_wa' => $request->no_wa,
                'status_pegawai' => $request->status_pegawai
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
            'email' => 'required|email|unique:users,email,' . $request->id_user,
            'name' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'district_id' => 'required',
            'status_pegawai' => 'required'
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {
            $data = User::find($request->id_user);
            $data->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $data->password ?? Hash::make($request->password),
            ]);

            $profil = Profil::find($request->id);
            $profil->update([
                'nip'           => $request->nip,
                'nik'           => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat'        => $request->alamat,
                'id_user'       => $request->id_user,
                'district_id'   => $request->district_id,
                'status_pegawai' => $request->status_pegawai,
                'pangkat'       => $request->pangkat, 
                'jabatan'       => $request->jabatan
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Berhasil Didaftarkan!'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        $data = Profil::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
