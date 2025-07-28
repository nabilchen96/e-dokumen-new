<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Profil;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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

        if (
            Auth::user()->role == 'Admin' ||
            Auth::user()->role == 'Staff BKPSDM' ||
            Auth::user()->role == 'Kabid BKPSDM' ||
            Auth::user()->role == 'Sekretaris BKPSDM' ||
            Auth::user()->role == 'Kepala BKPSDM' ||
            Auth::user()->role == 'Inspektorat'
        ) {

            $profil = $profil->get();

        } elseif (Auth::user()->role == 'SKPD') {

            // Ambil ID skpd dari user SKPD yang sedang login
            $skpdId = Auth::user()->id_skpd;

            // dd($skpdId);

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
            'email'     => 'required|email|unique:users,email,' . $request->id_user,
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
            $data->update([
                'name' => $request->name,  
                'email' => $request->email, 
            ]);

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

        if(Request('profil') == '4'){
             return $this->detailApiSiasn();
        }

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

        if (
            Auth::user()->role == 'Admin' ||
            Auth::user()->role == 'Staff BKPSDM' ||
            Auth::user()->role == 'Kabid BKPSDM' ||
            Auth::user()->role == 'Sekretaris BKPSDM' ||
            Auth::user()->role == 'Kepala BKPSDM' ||
            Auth::user()->role == 'Inspektorat' ||
            Auth::user()->role == 'SKPD' ||
            Auth::user()->role == 'OPD'
        ) {

            $profil = $profil->first();

        }
        // elseif (Auth::user()->role == 'SKPD') {

        //     $profil = $profil->where('users.id_creator', Auth::id())->first();

        // } 
        else {

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

    public function exportExcel()
    {
        // Ambil data dari database
        $data = DB::table('users')
            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
            ->leftJoin('unit_kerjas', 'unit_kerjas.id', '=', 'profils.id_unit_kerja')
            ->leftJoin('skpds', 'skpds.id', '=', 'unit_kerjas.id_skpd')
            ->where('users.role', 'Pegawai')
            ->get([
                'profils.*',
                'users.name', 
                'users.email', 
                'users.no_wa', 
                'skpds.nama_skpd',
                'unit_kerjas.unit_kerja', 
                'users.role'
            ]);

        // Buat instance baru dari Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan judul kolom
        $headerColumns = [
            'A1' => '#',
            'B1' => 'NAMA',
            'C1' => 'EMAIL',
            'D1' => 'NO WA',
            'E1' => 'ROLE',
            'F1' => 'STATUS',
            'G1' => 'NIP',
            'H1' => 'NIK',
            'I1' => 'JENIS KELAMIN',
            'J1' => 'TEMPAT LAHIR',
            'K1' => 'TANGGAL LAHIR',
            'L1' => 'PANGKAT',
            'M1' => 'JABATAN',
            'N1' => 'GOLONGAN',
            'O1' => 'SKPD',
            'P1' => 'UNIT KERJA',
            'Q1' => 'AGAMA', 
            'R1' => 'STATUS KAWIN', 
            'S1' => 'ALAMAT', 
            'T1' => 'GELAR DEPAN', 
            'U1' => 'GELAR BELAKANG', 
            'V1' => 'EMAIL GOV', 
            'W1' => 'NPWP', 
            'X1' => 'BPJS', 
            'Y1' => 'JENIS PEGAWAI', 
            'Z1' => 'STATUS HUKUM', 
            'AA1' => 'STATUS ASN', 
            'AB1' => 'KARTU ASN VIRTUAL', 
            'AC1' => 'NOMOR SK CPNS/P3K', 
            'AD1' => 'TANGGAL SK CPNS/P3K', 
            'AE1' => 'NOMOR SK PNS', 
            'AF1' => 'TANGGAL SK PNS', 
            'AG1' => 'TMT PNS',
            'AH1' => 'TMT GOLONGAN', 
            'AI1' => 'MASA KERJA TAHUN', 
            'AJ1' => 'MASA KERJA BULAN', 
            'AK1' => 'JENIS JABATAN', 
            'AL1' => 'TINGKAT PENDIDIKAN',
            'AM1' => 'JURUSAN', 
            'AN1' => 'KPPN', 

        ];
        foreach ($headerColumns as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        // Tambahkan styling untuk header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ];
        $sheet->getStyle('A1:AN1')->applyFromArray($headerStyle);

        // Tambahkan data dari database ke spreadsheet
        $row = 2;
        $totalRows = $data->count();
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->name);
            $sheet->setCellValue('C' . $row, $item->email);
            $sheet->setCellValue('D' . $row, $item->no_wa);
            $sheet->setCellValue('E' . $row, $item->role);
            $sheet->setCellValue('F' . $row, $item->status_pegawai);
            $sheet->setCellValue('G' . $row, "`$item->nip");
            $sheet->setCellValue('H' . $row, "`$item->nik");
            $sheet->setCellValue('I' . $row, $item->jenis_kelamin);
            $sheet->setCellValue('J' . $row, $item->tempat_lahir);
            $sheet->setCellValue('K' . $row, $item->tanggal_lahir);
            $sheet->setCellValue('L' . $row, $item->status_pegawai == 'Honorer' ? '' : $item->pangkat);
            $sheet->setCellValue('M' . $row, $item->status_pegawai == 'Honorer' ? '' : $item->jabatan);
            $sheet->setCellValue('N' . $row, $item->status_pegawai == 'Honorer' ? '' : $item->golongan);
            $sheet->setCellValue('O' . $row, $item->instansi_kerja);
            $sheet->setCellValue('P' . $row, $item->satuan_kerja);
            $sheet->setCellValue('Q' . $row, $item->agama);
            $sheet->setCellValue('R' . $row, $item->status_kawin);
            $sheet->setCellValue('S' . $row, $item->alamat);
            $sheet->setCellValue('T' . $row, $item->gelar_depan);
            $sheet->setCellValue('U' . $row, $item->gelar_belakang);
            $sheet->setCellValue('V' . $row, $item->email_gov);
            $sheet->setCellValue('W' . $row, $item->npwp);
            $sheet->setCellValue('X' . $row, $item->bpjs);
            $sheet->setCellValue('Y' . $row, $item->jenis_pegawai);
            $sheet->setCellValue('Z' . $row, $item->kedudukan_hukum);
            $sheet->setCellValue('AA' . $row, $item->status_cpns);
            $sheet->setCellValue('AB' . $row, $item->kartu_asn_virtual);
            $sheet->setCellValue('AC' . $row, $item->nomor_sk_cpns);
            $sheet->setCellValue('AD' . $row, $item->tanggal_sk_cpns);
            $sheet->setCellValue('AE' . $row, $item->nomor_sk_pns);
            $sheet->setCellValue('AF' . $row, $item->tanggal_sk_pns);
            $sheet->setCellValue('AG' . $row, $item->tmt_pns);
            $sheet->setCellValue('AH' . $row, $item->tmt_golongan);
            $sheet->setCellValue('AI' . $row, $item->mk_tahun);
            $sheet->setCellValue('AJ' . $row, $item->mk_bulan);
            $sheet->setCellValue('AK' . $row, $item->jenis_jabatan);
            $sheet->setCellValue('AL' . $row, $item->tingkat_pendidikan);
            $sheet->setCellValue('AM' . $row, $item->jurusan_pendidikan);
            $sheet->setCellValue('AN' . $row, $item->kpkn);

            // Terapkan garis pada setiap baris kecuali baris terakhir
            $sheet->getStyle("A$row:AN$row")->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                ]
            ]);

            $row++;
        }

        // Otomatis menyesuaikan lebar kolom
        foreach (range('A', 'AN') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Buat writer untuk menulis file Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'pegawai.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Tulis file ke lokasi sementara
        $writer->save($temp_file);

        // Berikan respon file kepada pengguna
        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function getAuthorizationToken()
    {
        $username = 't9FAxeuvRvFhh4OTARTBkmQjOfQa';
        $password = 'UwxWRfypponkptfJOB1QRnCtkHca';

        $response = Http::asForm()->withBasicAuth($username, $password)->post('https://apimws.bkn.go.id/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['access_token'];
        }

        return response()->json([
            'error' => 'Gagal mendapatkan token',
            'message' => $response->body()
        ], $response->status());
    }

    public function detailApiSiasn()
    {
        $token = Cache::remember('bkn_token', 36000, function () {
            return $this->getAuthorizationToken();
        });

        $profil = DB::table('profils')->where('id', Request('id'))->first();

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Auth' => 'Bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3NTIyNDY3NjgsImlhdCI6MTc1MjIwMzU2OCwianRpIjoiN2RjNjAyY2EtYTU2Yi00NzhlLWI1NDYtNmM3NzM3ZjlmMzJjIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6WyJpZGlzIiwiYWNjb3VudCJdLCJzdWIiOiI5OTliNGE1OS05ZDJjLTQyODUtODlhOS0yNjAzZjY5NjZlZWYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJiZW5na3VsdXV0YXJhYXBpIiwic2Vzc2lvbl9zdGF0ZSI6IjFhZjA5NzMyLWVhYTQtNDA1ZS1hZTI0LWM4Yjc0ZDNhZTU5YSIsImFjciI6IjEiLCJyZWFsbV9hY2Nlc3MiOnsicm9sZXMiOlsicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbWFqYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOmlwYXNuOm1vbml0b3JpbmciLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInVtYV9hdXRob3JpemF0aW9uIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwcm9maWxhc246dmlld3Byb2ZpbCJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImlkaXMiOnsicm9sZXMiOlsiYWdlbmN5LWFkbWluIl19LCJhY2NvdW50Ijp7InJvbGVzIjpbIm1hbmFnZS1hY2NvdW50IiwibWFuYWdlLWFjY291bnQtbGlua3MiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6ImVtYWlsIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJGSVJBUyBTRU5BIEhBSVRTQU0iLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiIxOTk2MDkwODIwMjUwNDEwMDUiLCJnaXZlbl9uYW1lIjoiRklSQVMiLCJmYW1pbHlfbmFtZSI6IlNFTkEgSEFJVFNBTSIsImVtYWlsIjoic2VuYWhhaXRzYW0wOEBnbWFpbC5jb20ifQ.S1JFFe5-9JuRQEfuAJ5Op4ttm4SRvQa9zNg_yiGGpvIal9_pn8AIqbG9elNZi9Nk8pGUoWKuolknpMZo4fMdkgw4QiCn-b5qQwMlw4XAGdpJrg5vKU27ejMdu7IrR6Z2DgC974c-W-zM0S5nmu1wtQFeUeni3rzkuOutq5FXyH7VNziKEgtwpsVnpZ1u2Ptmy-Y1Y8GL0pG7yBPr1uMXDhHOUkz3XtmvwF9ZcxOaPk_3nftxDFEt5qZpK07xqdRnkuU_lx8_uEhfHAud3O4BJfGxy3JMyPLdnB5U8z_dntC7h1iF9DtEBebWWHwxk-1OeiAkTXIzfYLxCy3hyb7TYg', // token statis dari BKN
            'Authorization' => 'Bearer ' . $token,
        ])->get("https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/data-utama/".$profil->nip);

        return view('backend.api_siasn.profile.detail', [
            'response' => $response->json()
        ]);
    }
}
