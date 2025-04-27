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
            ->leftJoin('unit_kerjas', 'unit_kerjas.id', '=', 'profils.id_unit_kerja')
            ->leftJoin('skpds', 'skpds.id', '=', 'unit_kerjas.id_skpd')
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
                'unit_kerjas.unit_kerja',
                'skpds.nama_skpd'
            );

        if (Auth::user()->role == 'Admin') {

            $profil = $profil->get();

        } elseif (Auth::user()->role == 'SKPD') {

            $profil = $profil->where('users.id_creator', Auth::id())->get();

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

    public function updateProfil(Request $request)
    {

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_user' => 'required',
            'name' => 'required',
            'nik' => 'required',
            // 'email'     => 'required|email|unique:users,email,' . $request->id_user,
            'no_wa' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

            return back()->with('data', $data)->withInput();

        } else {
            $data = User::find($request->id_user);

            $profil = Profil::find($request->id);
            $profil->update([
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'id_user' => $request->id_user,
                'agama' => $request->agama,
                'status_kawin' => $request->status_kawin,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'tingkat_pendidikan' => $request->tingkat_pendidikan,
                'tahun_lulus' => $request->tahun_lulus,
                'jurusan_pendidikan' => $request->jurusan_pendidikan,
                'npwp' => $request->npwp,
                'bpjs' => $request->bpjs

                // 'district_id' => $request->district_id ?? $profil->district_id,
                // 'status_pegawai' => $request->status_pegawai,
                // 'pangkat' => $request->pangkat,
                // 'jabatan' => $request->jabatan,
                // 'id_unit_kerja' => $request->id_unit_kerja ?? $profil->id_unit_kerja
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Berhasil Didaftarkan!'
            ];
        }

        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function updateProfilPegawai(Request $request)
    {

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_user' => 'required',
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

            return back()->with('data', $data)->withInput();

        } else {
            $data = User::find($request->id_user);

            $profil = Profil::find($request->id);
            $profil->update($request->all());

        }

        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function detail()
    {

        $data = $profil = DB::table('users')
            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
            ->leftJoin('districts', 'districts.id', '=', 'profils.district_id')
            ->leftJoin('unit_kerjas', 'unit_kerjas.id', '=', 'profils.id_unit_kerja')
            ->leftJoin('skpds', 'skpds.id', '=', 'unit_kerjas.id_skpd')
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
                'unit_kerjas.unit_kerja',
                'skpds.nama_skpd'
            )->where('profils.id', Request('id'));

        if (Auth::user()->role == 'Admin') {

            $profil = $profil->first();

        } elseif (Auth::user()->role == 'SKPD') {

            $profil = $profil->where('users.id_creator', Auth::id())->first();

        } else {

            $profil = $profil->where('users.id', Auth::id())->first();
        }


        return view('backend.profil.detail', [
            'profil' => $profil
        ]);
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
