<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class UnitKerjaController extends Controller
{
    public function index(Request $request){

        $perPage = $request->input('per_page', 20);

        $data = DB::table('unit_kerjas')->simplePaginate($perPage);

        return response()->json($data, 200);
    }
}
