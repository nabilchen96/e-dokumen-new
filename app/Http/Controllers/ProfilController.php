<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Profil;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function index(){
        return view('backend.profil.index');
    }

    public function data(){
        
        $profil = DB::table('profils')
                ->Join('users', 'users.id', '=', 'profils.id_user')
                ->Join('districts', 'districts.id', '=', 'profils.district_id')
                ->select(
                    'users.name',
                    'users.email',
                    'users.no_wa',
                    'users.role',
                    'profils.*',
                    'districts.name as district',
                    'districts.latitude',
                    'districts.longitude'
                );

        if(Auth::user()->role == 'Admin'){
            $profil = $profil->get();
        }else{
            $profil = $profil->where('id_user', Auth::id())->get();
        }

        
        return response()->json(['data' => $profil]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'password'   => 'required|min:8',
            'email'      => 'unique:users',
            'no_wa'      => 'unique:users'
        ]);

        if($validator->fails()){
            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];
        }else{
            $data = Profil::create([
                'name'          => $request->name,
                'role'          => $request->role,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'no_wa'         => $request->no_wa,
            ]);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'id'    => 'required',
            'name'    => 'required',
            'email'    => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];
        }else{

            $user = Profil::find($request->id);
            $data = $user->update([
                'name'      => $request->name,
                'role'      => $request->role,
                'email'     => $request->email,
                'no_wa'     => $request->no_wa,
                'password'  => $request->password ? Hash::make($request->password) : $user->password
            ]);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request){

        $data = Profil::find($request->id)->delete();

        $data = [
            'responCode'    => 1,
            'respon'        => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
