<?php

namespace App\Http\Controllers\ApiSiasn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ProfilController extends Controller
{
    public function index(){
        return view('backend.api_siasn.profile.index');
    }

    public function data()
    {

        $profil = DB::table('users')
            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
            ->whereNotIn('users.role', ['Admin'])
            ->where('profils.status_pegawai', 'PNS')
            ->select(
                'users.name',
                'users.email',
                'users.no_wa',
                'users.role',
                'profils.*'
            );

        if (in_array(Auth::user()->role, ['Admin','Staff BKPSDM','Kabid BKPSDM','Sekretaris BKPSDM','Kepala BKPSDM','Inspektorat'])) {

            $profil = $profil->get();

        } elseif (Auth::user()->role == 'SKPD') {

            // Ambil ID skpd dari user SKPD yang sedang login
            $skpdId = Auth::user()->id_skpd;

            if ($skpdId === null) {
                // Jika user SKPD belum punya skpd, kembalikan data kosong
                $profil = collect(); // atau bisa juga response kosong

            } else {
                
                $profil = $profil->join('skpds as uk_filter', 'uk_filter.nama_skpd', '=', 'profils.instansi_kerja')
                            ->where('uk_filter.id', Auth::user()->id_skpd)->get();
            }

        } else if (Auth::user()->role == 'OPD') {

            // Ambil ID unit kerja dari user OPD yang sedang login
            $unitKerjaId = Auth::user()->id_unit_kerja;

            if ($unitKerjaId === null) {
                // Jika user OPD belum punya unit kerja, kembalikan data kosong
                $profil = collect(); // atau bisa juga response kosong
            } else {
                
                $profil = $profil->join('unit_kerjas as uk_filter', 'uk_filter.unit_kerja', '=', 'profils.satuan_kerja')
                            ->where('uk_filter.id', Auth::user()->id_unit_kerja)->get();
            }

        } else {

            $profil = $profil->where('users.id', Auth::id())->get();
        }


        return response()->json(['data' => $profil]);
    }

    public function getAuthorizationToken()
    {
        $username = 't9FAxeuvRvFhh4OTARTBkmQjOfQa'; // Ganti sesuai yang kamu dapat
        $password = 'UwxWRfypponkptfJOB1QRnCtkHca'; // Ganti dengan yang asli

        $response = Http::asForm()->withBasicAuth($username, $password)->post('https://apimws.bkn.go.id/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['access_token']; // ini adalah token Authorization (Bearer)
        }

        return response()->json([
            'error' => 'Gagal mendapatkan token',
            'message' => $response->body()
        ], $response->status());
    }

    public function detail(){

        $token = Cache::remember('bkn_token', 36000, function () {
            return $this->getAuthorizationToken();
        });

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Auth' => 'Bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3NTIyNDY3NjgsImlhdCI6MTc1MjIwMzU2OCwianRpIjoiN2RjNjAyY2EtYTU2Yi00NzhlLWI1NDYtNmM3NzM3ZjlmMzJjIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6WyJpZGlzIiwiYWNjb3VudCJdLCJzdWIiOiI5OTliNGE1OS05ZDJjLTQyODUtODlhOS0yNjAzZjY5NjZlZWYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJiZW5na3VsdXV0YXJhYXBpIiwic2Vzc2lvbl9zdGF0ZSI6IjFhZjA5NzMyLWVhYTQtNDA1ZS1hZTI0LWM4Yjc0ZDNhZTU5YSIsImFjciI6IjEiLCJyZWFsbV9hY2Nlc3MiOnsicm9sZXMiOlsicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbWFqYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOmlwYXNuOm1vbml0b3JpbmciLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInVtYV9hdXRob3JpemF0aW9uIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwcm9maWxhc246dmlld3Byb2ZpbCJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImlkaXMiOnsicm9sZXMiOlsiYWdlbmN5LWFkbWluIl19LCJhY2NvdW50Ijp7InJvbGVzIjpbIm1hbmFnZS1hY2NvdW50IiwibWFuYWdlLWFjY291bnQtbGlua3MiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6ImVtYWlsIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJGSVJBUyBTRU5BIEhBSVRTQU0iLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiIxOTk2MDkwODIwMjUwNDEwMDUiLCJnaXZlbl9uYW1lIjoiRklSQVMiLCJmYW1pbHlfbmFtZSI6IlNFTkEgSEFJVFNBTSIsImVtYWlsIjoic2VuYWhhaXRzYW0wOEBnbWFpbC5jb20ifQ.S1JFFe5-9JuRQEfuAJ5Op4ttm4SRvQa9zNg_yiGGpvIal9_pn8AIqbG9elNZi9Nk8pGUoWKuolknpMZo4fMdkgw4QiCn-b5qQwMlw4XAGdpJrg5vKU27ejMdu7IrR6Z2DgC974c-W-zM0S5nmu1wtQFeUeni3rzkuOutq5FXyH7VNziKEgtwpsVnpZ1u2Ptmy-Y1Y8GL0pG7yBPr1uMXDhHOUkz3XtmvwF9ZcxOaPk_3nftxDFEt5qZpK07xqdRnkuU_lx8_uEhfHAud3O4BJfGxy3JMyPLdnB5U8z_dntC7h1iF9DtEBebWWHwxk-1OeiAkTXIzfYLxCy3hyb7TYg', // token statis dari BKN
            'Authorization' => 'Bearer ' . $token,
        ])->get("https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/data-utama/".Request('nip'));

        return view('backend.api_siasn.profile.detail', [
            'response' => $response->json()
            // 'response' => []
        ]);
    }
}
