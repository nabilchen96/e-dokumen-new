<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Instansi;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class InstansiController extends Controller
{
    public function index()
    {
        return view('backend.instansi.index');
    }

    public function data()
    {

        $data = DB::table('instansis')
            ->join('profils', 'profils.id', '=', 'instansis.id_profil')
            ->join('users', 'users.id', '=', 'profils.id_user')
            ->select(
                'users.name',
                'profils.nip',
                'instansis.*'
            )
            ->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_profil' => 'required',
            'status' => 'required',
            'kode_pos' => 'required',
            'email' => 'required',
            'website' => 'required',
            'telp_fax' => 'required',
            'logo' => 'required|mimes:jpg,jpeg,png',
        ], [
            'logo.mimes' => 'Logo harus berformat JPG, atau PNG.',
            'logo.required' => 'Logo harus/wajib diisi',
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            //LOGO
            if ($request->logo) {
                $logo = time() . '.' . $request->logo->extension();
                $request->logo->move(public_path('logo'), $logo);
            }

            if($request->status == 'Aktif'){
                Instansi::query()->update(['status' => 'Tidak Aktif']);
            }

            $data = Instansi::create([
                'id_profil' => $request->id_profil,
                'status' => $request->status,
                'kode_pos' => $request->kode_pos,
                'email' => $request->email,
                'website' => $request->website,
                'telp_fax' => $request->telp_fax,
                'alamat' => 'Jln. DR.M.Hatta Nomor 11',
                'logo' => $logo
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
            'id_profil' => 'required',
            'status' => 'required',
            'kode_pos' => 'required',
            'email' => 'required',
            'website' => 'required',
            'telp_fax' => 'required',
            'logo' => 'mimes:jpg,jpeg,png',
        ], [
            'logo.mimes' => 'Logo harus berformat JPG, atau PNG.',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //LOGO
            if ($request->logo) {
                $logo = time() . '.' . $request->logo->extension();
                $request->logo->move(public_path('logo'), $logo);
            }

            if($request->status == 'Aktif'){
                Instansi::query()->update(['status' => 'Tidak Aktif']);
            }

            $user = Instansi::find($request->id);
            $data = $user->update([
                'id_profil' => $request->id_profil,
                'status' => $request->status,
                'kode_pos' => $request->kode_pos,
                'email' => $request->email,
                'website' => $request->website,
                'telp_fax' => $request->telp_fax,
                'alamat' => 'Jln. DR.M.Hatta Nomor 11',
                'logo' => $logo ?? $user->logo
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

        $data = Instansi::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
