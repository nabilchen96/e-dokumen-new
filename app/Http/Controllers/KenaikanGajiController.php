<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\KenaikanGaji;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PDF; //library pdf
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

class KenaikanGajiController extends Controller
{
    public function index()
    {
        return view('backend.kenaikan_gaji.index');
    }

    public function data()
    {

        $data = DB::table('kenaikan_gajis')
            ->leftjoin('profils', 'profils.id', '=', 'kenaikan_gajis.id_profil')
            ->leftjoin('profils as k', 'k.id', '=', 'kenaikan_gajis.id_profil_kepala')
            ->leftjoin('users', 'users.id', '=', 'profils.id_user')
            ->leftjoin('users as u', 'u.id', '=', 'k.id_user')
            ->select(
                'kenaikan_gajis.*',
                'u.name',
                'k.nip',
                'users.name',
                'profils.nip',
            )
            ->get();

        return response()->json(['data' => $data]);
    }

    public function edit(Request $request)
    {

        return view('backend.kenaikan_gaji.edit');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_profil' => 'required',
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            $data = KenaikanGaji::create($request->all());

            return redirect()->route('edit-kenaikan-gaji', [
                'data' => $data
            ]);

        }

    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            if ($request->masa_kerja_tahun_sebelumnya < 10) {
                $request->masa_kerja_tahun_sebelumnya = str_pad($request->masa_kerja_tahun_sebelumnya, 2, '0', STR_PAD_LEFT);
            }

            if ($request->masa_kerja_bulan_sebelumnya < 10) {
                $request->masa_kerja_bulan_sebelumnya = str_pad($request->masa_kerja_bulan_sebelumnya, 2, '0', STR_PAD_LEFT);
            }

            if ($request->masa_kerja_tahun_baru < 10) {
                $request->masa_kerja_tahun_baru = str_pad($request->masa_kerja_tahun_baru, 2, '0', STR_PAD_LEFT);
            }

            if ($request->masa_kerja_bulan_baru < 10) {
                $request->masa_kerja_bulan_baru = str_pad($request->masa_kerja_tahun_baru, 2, '0', STR_PAD_LEFT);
            }

            // dd($request->masa_kerja_bulan_baru);

            $request->merge([
                'masa_kerja_tahun_sebelumnya' => $request->masa_kerja_tahun_sebelumnya,
                'masa_kerja_bulan_sebelumnya' => $request->masa_kerja_bulan_sebelumnya,
                'masa_kerja_tahun_baru' => $request->masa_kerja_tahun_baru, 
                'masa_kerja_bulan_baru' => $request->masa_kerja_bulan_baru
            ]);

            $user = KenaikanGaji::find($request->id);
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

        $data = KenaikanGaji::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }

    public function export()
    {
        $templatePath = public_path('templates/template_kenaikan_gaji.docx');

        // Buat instance TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);

        $instansi = DB::table('instansis')->where('status', 'Aktif')->first();

        // Data Kenaikan gaji
        $data = DB::table('kenaikan_gajis')
            ->leftjoin('profils', 'profils.id', '=', 'kenaikan_gajis.id_profil')
            ->leftjoin('users', 'users.id', '=', 'profils.id_user')
            
            ->leftjoin('profils as k', 'k.id', '=', 'kenaikan_gajis.id_profil_kepala')
            ->leftjoin('users as u', 'u.id', '=', 'k.id_user')
            
            ->select(
                'kenaikan_gajis.*',

                //PEGAWAI
                'profils.nip as nip_pegawai',
                'profils.tanggal_lahir',
                'profils.pangkat as pangkat_pegawai',
                'profils.jabatan as jabatan_pegawai',

                'users.name as nama_pegawai',
                
                //KEPALA
                'u.name as nama_kepala',
                'k.nip as nip_kepala',
                'k.pangkat as pangkat_kepala'

            )
            ->where('kenaikan_gajis.id', Request('data'))
            ->first();

            $pangkat = explode(" - ", @$data->pangkat_pegawai);
            $kepala = explode(" - ", @$data->pangkat_kepala);
            

        // Ganti placeholder dengan data dinamis
        $templateProcessor->setValue('telp_fax', @$data->telp_fax);
        $templateProcessor->setValue('kode_pos', @$data->kode_pos);
        $templateProcessor->setValue('website', @$data->website);
        $templateProcessor->setValue('email', @$data->email);

        $templateProcessor->setValue('tgl_dokumen', Carbon::createFromFormat('Y-m-d', $data->tgl_dokumen)->translatedFormat('d F Y'));
        $templateProcessor->setValue('no_dokumen', $data->no_dokumen);
        $templateProcessor->setValue('lampiran', $data->lampiran);
        $templateProcessor->setValue('nama', $data->nama_pegawai);
        $templateProcessor->setValue('tgl_lahir', date('d-m-Y', strtotime($data->tanggal_lahir)));
        $templateProcessor->setValue('nip', $data->nip_pegawai);
        $templateProcessor->setValue('pangkat', $pangkat[1]);
        $templateProcessor->setValue('jabatan', $data->jabatan_pegawai);
        $templateProcessor->setValue('kantor', $data->skpd);
        $templateProcessor->setValue('gaji_pokok_lama', 'Rp. ' . number_format($data->gaji_pokok_lama, 0, ',', '.') . ',-');
        $templateProcessor->setValue('oleh_pejabat', $data->oleh_pejabat);
        $templateProcessor->setValue('tgl_dok_sebelumnya', date('d-m-Y', strtotime($data->tgl_dokumen_sebelumnya)));
        $templateProcessor->setValue('no_dok_sebelumnya', $data->no_dokumen_sebelumnya);
        $templateProcessor->setValue('tgl_berlaku_gaji', Carbon::createFromFormat('Y-m-d', $data->tgl_berlaku_gaji)->translatedFormat('d F Y'));
        $templateProcessor->setValue('mkts', $data->masa_kerja_tahun_sebelumnya != null ? $data->masa_kerja_tahun_sebelumnya : '0');
        $templateProcessor->setValue('mkbs', $data->masa_kerja_bulan_sebelumnya != null ? $data->masa_kerja_bulan_sebelumnya : '0');
        $templateProcessor->setValue('gaji_pokok_baru', 'Rp. ' . number_format($data->gaji_pokok_baru, 0, ',', '.') . ',-');
        $templateProcessor->setValue('mktb', $data->masa_kerja_tahun_baru != null ? $data->masa_kerja_tahun_baru : '0');
        $templateProcessor->setValue('mkbb', $data->masa_kerja_bulan_baru != null ? $data->masa_kerja_bulan_baru : '0');
        $templateProcessor->setValue('golongan', $pangkat[0]);
        $templateProcessor->setValue('tgl_terhitung_mulai', Carbon::createFromFormat('Y-m-d', $data->tgl_terhitung_mulai)->translatedFormat('d F Y'));
        $templateProcessor->setValue('tgl_kenaikan_berikutnya', Carbon::createFromFormat('Y-m-d', $data->tgl_kenaikan_berikutnya)->translatedFormat('d F Y'));

        $templateProcessor->setValue('nama_kepala', $data->nama_kepala);
        $templateProcessor->setValue('pangkat_kepala', $kepala[2]);
        $templateProcessor->setValue('nip_kepala', $data->nip_kepala);

        // Path untuk menyimpan hasil
        $outputPath = storage_path('app/public/output.docx');

        // Simpan file hasil
        $templateProcessor->saveAs($outputPath);

        // Kembalikan file sebagai respons download
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
