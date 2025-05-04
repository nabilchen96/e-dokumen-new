<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\ProsesKenaikanGaji;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProsesKenaikanGajiController extends Controller
{
    public function index()
    {
        $data = DB::table('proses_kenaikan_gajis as pkg')
            ->leftJoin('users as user_0', 'user_0.id', '=', 'pkg.id_user_0')
            ->leftJoin('users as user_1', 'user_1.id', '=', 'pkg.id_user_1')
            ->leftJoin('users as user_2', 'user_2.id', '=', 'pkg.id_user_2')
            ->leftJoin('users as user_3', 'user_3.id', '=', 'pkg.id_user_3')
            ->leftJoin('users as user_4', 'user_4.id', '=', 'pkg.id_user_4')
            ->leftJoin('users as user_5', 'user_5.id', '=', 'pkg.id_user_5')
            ->select(
                'user_0.name as name_0',
                'user_1.name as name_1',
                'user_2.name as name_2',
                'user_3.name as name_3',
                'user_4.name as name_4',
                'user_5.name as name_5',
                'pkg.*'
            )->get();

        return view('backend.proses_kenaikan_gaji.index', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_pengantar' => [
                'required',
                'file',
                'mimes:pdf',
                function ($attribute, $value, $fail) {
                    // Cek jika file adalah PDF dan pastikan ukuran tidak lebih dari 1MB
                    if ($value->getClientOriginalExtension() == 'pdf' && $value->getSize() > 1024 * 1024) {
                        $fail('Ukuran PDF tidak boleh lebih dari 1MB.');
                    }
                },
            ],
        ], [
            'file_pengantar.file' => 'Dokumen yang diunggah harus berupa file.',
            'file_pengantar.mimes' => 'Dokumen harus berformat PDF, JPG, atau PNG.',
            'file_pengantar.max' => 'Ukuran dokumen maksimal adalah 1MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'responCode' => 0,
                'respon' => $validator->errors(),
            ]);
        }

        $dokumen = $request->file('file_pengantar');
        $nama_dokumen = date('YmdHis') . '.' . $dokumen->extension();
        $dokumen->move(public_path('file_pengantar'), $nama_dokumen);

        // Simpan data ke database
        $data = ProsesKenaikanGaji::create([
            'file_pengantar' => $nama_dokumen,
            'id_user_0' => Auth::id(),
            'waktu_0' => now()
        ]);

        return response()->json([
            'responCode' => 1,
            'respon' => 'Data Sukses Ditambah',
        ]);
    }

    public function detail()
    {

        $data = DB::table('proses_kenaikan_gajis as pkg')
            ->leftJoin('users as user_0', 'user_0.id', '=', 'pkg.id_user_0')
            ->leftJoin('users as user_1', 'user_1.id', '=', 'pkg.id_user_1')
            ->leftJoin('users as user_2', 'user_2.id', '=', 'pkg.id_user_2')
            ->leftJoin('users as user_3', 'user_3.id', '=', 'pkg.id_user_3')
            ->leftJoin('users as user_4', 'user_4.id', '=', 'pkg.id_user_4')
            ->leftJoin('users as user_5', 'user_5.id', '=', 'pkg.id_user_5')
            ->select(
                'user_0.name as name_0',
                'user_1.name as name_1',
                'user_2.name as name_2',
                'user_3.name as name_3',
                'user_4.name as name_4',
                'user_5.name as name_5',
                'pkg.*'
            )->where('pkg.id', Request('id'))->first();

        return view('backend.proses_kenaikan_gaji.detail', [
            'data' => $data
        ]);
    }

    public function verifikasi(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'verifikasi_proses' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $data = ProsesKenaikanGaji::where('id', request('id'))->first();
            // Jangan lanjut jika ada status sebelumnya yang "Ditolak"
            if (
                $data->status_1 == 'Ditolak' ||
                $data->status_2 == 'Ditolak' ||
                $data->status_3 == 'Ditolak' ||
                $data->status_4 == 'Ditolak'
            ) {
                // Tampilkan pesan: "Proses dihentikan karena ditolak pada tahap sebelumnya."

                $data = [
                    'responCode' => 0,
                    'respon' => 'Data Gagal Diupdate Karena Proses Sudah Ditolak'
                ];

                return response()->json($data);
            }

            // Tahap 1: Staff BKPSDM atau Admin (status_1 harus NULL)
            if (
                $data->status_1 == NULL &&
                (Auth::user()->role == 'Staff BKPSDM' || Auth::user()->role == 'Admin')
            ) {
                // Approve atau tidak approve oleh Staff BKPSDM
                $data->update([
                    'status_1' => $request->verifikasi_proses,
                    'id_user_1' => Auth::id(),
                    'waktu_1' => now()
                ]);
            }

            // Tahap 2: Kabid BKPSDM atau Admin (status_1 harus 'Disetujui', status_2 harus NULL)
            if (
                $data->status_1 == 'Disetujui' &&
                $data->status_2 == NULL &&
                (Auth::user()->role == 'Kabid BKPSDM' || Auth::user()->role == 'Admin')
            ) {
                // Approve atau tidak approve oleh Kabid
                $data->update([
                    'status_2' => $request->verifikasi_proses,
                    'id_user_2' => Auth::id(),
                    'waktu_2' => now()
                ]);
            }

            // Tahap 3: Sekretaris BKPSDM atau Admin (status_2 harus 'Disetujui', status_3 harus NULL)
            if (
                $data->status_2 == 'Disetujui' &&
                $data->status_3 == NULL &&
                (Auth::user()->role == 'Sekretaris BKPSDM' || Auth::user()->role == 'Admin')
            ) {
                // Approve atau tidak approve oleh Sekretaris
                $data->update([
                    'status_3' => $request->verifikasi_proses,
                    'id_user_3' => Auth::id(),
                    'waktu_3' => now()
                ]);
            }

            // Tahap 4: Kepala BKPSDM atau Admin (status_3 harus 'Disetujui', status_4 harus NULL)
            if (
                $data->status_3 == 'Disetujui' &&
                $data->status_4 == NULL &&
                (Auth::user()->role == 'Kepala BKPSDM' || Auth::user()->role == 'Admin')
            ) {
                // Rilis atau tidak rilis oleh Kepala
                $data->update([
                    'status_4' => $request->verifikasi_proses,
                    'id_user_4' => Auth::id(),
                    'waktu_4' => now()
                ]);
            }

            // Tahap 5: Bendahara Gaji atau Admin (status_4 harus 'Dirilis', status_5 harus NULL misalnya)
            if (
                $data->status_4 == 'Dirilis' &&
                (Auth::user()->role == 'Bendahara Gaji DPKAD' || Auth::user()->role == 'Admin')
            ) {
                // Bayar atau tidak bayar
                $data->update([
                    'status_5' => $request->verifikasi_proses,
                    'id_user_5' => Auth::id(),
                    'waktu_5' => $request->waktu_5
                ]);
            }

            $data = [
                'responCode' => 1,
                'respon' => 'Data Berhasil Diupdate'
            ];

            return response()->json($data);
        }
    }
}
