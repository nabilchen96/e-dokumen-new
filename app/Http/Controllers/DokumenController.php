<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Dokumen;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class DokumenController extends Controller
{
    public function index()
    {
        return view('backend.dokumen.index');
    }

    public function data()
    {

        $data = DB::table('dokumens')
            ->leftJoin('users', 'users.id', '=', 'dokumens.id_user')
            ->leftJoin('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
            ->leftJoin('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
            ->leftJoin('unit_kerjas', 'unit_kerjas.id', '=', 'dokumens.id_unit_kerja')
            ->select(
                'dokumens.*',
                'jenis_dokumens.jenis_dokumen',
                'users.name',
                'skpds.nama_skpd',
                'unit_kerjas.unit_kerja'
            )
            ->where('jenis_dokumens.id', Request('jenis_dokumen'));


        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'OPD' || Auth::user()->role == 'Kepala BKPSDM') {

            $data = $data->get();

        } elseif (Auth::user()->role == 'Pegawai') {

            $data = $data->where('dokumens.id_user', Auth::id())->get();

        } elseif (Auth::user()->role == 'SKPD'){

            $data = $data->where('users.id_creator', Auth::id())->get();

        }


        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dokumen' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                function ($attribute, $value, $fail) {
                    // Cek jika file adalah PDF dan pastikan ukuran tidak lebih dari 1MB
                    if ($value->getClientOriginalExtension() == 'pdf' && $value->getSize() > 1024 * 1024) {
                        $fail('Ukuran PDF tidak boleh lebih dari 1MB.');
                    }
                },
            ],
            'tanggal_dokumen' => 'required',
        ], [
            'dokumen.file' => 'Dokumen yang diunggah harus berupa file.',
            'dokumen.mimes' => 'Dokumen harus berformat PDF, JPG, atau PNG.',
            'dokumen.max' => 'Ukuran dokumen maksimal adalah 1MB.',
            'tanggal_dokumen.required' => 'Tanggal Awal Dokumen Wajib Diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'responCode' => 0,
                'respon' => $validator->errors(),
            ]);
        }

        // CEK USER
        $pegawai = DB::table('users')
            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
            ->where('users.id', $request->id_user ?? Auth::id())
            ->select(
                'profils.nip',
                'users.name'
            )
            ->first();

        // CEK SKPD
        $skpd = DB::table('skpds')->where('id', $request->id_skpd)->first();

        $dokumen = $request->file('dokumen');
        $nama_dokumen = 'NIP_' . $pegawai->nip . '_' . $pegawai->name . '_' . $skpd->nama_skpd . '_' . date('YmdHis') . '.' . $dokumen->extension();

        // Proses pengecilan ukuran gambar
        if (in_array($dokumen->extension(), ['jpg', 'jpeg', 'png'])) {
            $image = Image::make($dokumen)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio(); // Maintain aspect ratio
                    $constraint->upsize();     // Prevent upsizing
                })
                ->encode($dokumen->extension(), 75); // Compress the image

            $path = public_path('dokumen/' . $nama_dokumen);
            $image->save($path);
        } else {
            $dokumen->move(public_path('dokumen'), $nama_dokumen);
        }

        // Simpan data ke database
        $data = Dokumen::create([
            'dokumen' => $nama_dokumen,
            'id_dokumen' => $request->id_dokumen,
            'id_user' => $request->id_user ?? Auth::id(),
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'tanggal_akhir_dokumen' => $request->tanggal_akhir_dokumen,
            'id_skpd' => $request->id_skpd,
            'jenis_dokumen_berkala' => $request->jenis_dokumen_berkala,
            'id_unit_kerja' => $request->id_unit_kerja
        ]);

        return response()->json([
            'responCode' => 1,
            'respon' => 'Data Sukses Ditambah',
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dokumen' => [
                'file',
                'mimes:pdf,jpg,jpeg,png',
                function ($attribute, $value, $fail) {
                    // Cek jika file adalah PDF dan pastikan ukuran tidak lebih dari 1MB
                    if ($value->getClientOriginalExtension() == 'pdf' && $value->getSize() > 1024 * 1024) {
                        $fail('Ukuran PDF tidak boleh lebih dari 1MB.');
                    }
                },
            ],
            'tanggal_dokumen' => 'required',
        ], [
            'dokumen.file' => 'Dokumen yang diunggah harus berupa file.',
            'dokumen.mimes' => 'Dokumen harus berformat PDF, JPG, atau PNG.',
            'dokumen.max' => 'Ukuran dokumen maksimal adalah 1MB.',
            'tanggal_dokumen.required' => 'Tanggal Awal Dokumen Wajib Diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'responCode' => 0,
                'respon' => $validator->errors()
            ]);
        }

        // CEK USER
        $pegawai = DB::table('users')
            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
            ->where('users.id', $request->id_user ?? Auth::id())
            ->select(
                'profils.nip',
                'users.name'
            )
            ->first();

        // CEK SKPD
        $skpd = DB::table('skpds')->where('id', $request->id_skpd)->first();

        $user = Dokumen::find($request->id);

        if ($request->hasFile('dokumen')) {
            $dokumen = $request->file('dokumen');
            $nama_dokumen = date('YmdHis') . '_' . $pegawai->nip . '_' . $pegawai->name . '_' . $skpd->nama_skpd . '.' . $dokumen->extension();

            // Proses pengecilan ukuran gambar
            if (in_array($dokumen->extension(), ['jpg', 'jpeg', 'png'])) {
                $image = Image::make($dokumen)
                    ->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio(); // Maintain aspect ratio
                        $constraint->upsize();     // Prevent upsizing
                    })
                    ->encode($dokumen->extension(), 75); // Compress the image

                $path = public_path('dokumen/' . $nama_dokumen);
                $image->save($path);
            } else {
                $dokumen->move(public_path('dokumen'), $nama_dokumen);
            }

            // Hapus file lama jika ada
            if ($user && $user->dokumen && file_exists(public_path('dokumen/' . $user->dokumen))) {
                unlink(public_path('dokumen/' . $user->dokumen));
            }
        } else {
            $nama_dokumen = $user->dokumen;
        }

        // Update data di database
        $user->update([
            'dokumen' => $nama_dokumen,
            'id_dokumen' => $request->id_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'tanggal_akhir_dokumen' => $request->tanggal_akhir_dokumen,
            'id_skpd' => $request->id_skpd ?? $user->id_skpd,
            'jenis_dokumen_berkala' => $request->jenis_dokumen_berkala,
            'status' => $user->status == 'Perlu Diperbaiki' && $request->file('dokumen') ? 'Belum Diperiksa' : $user->status,
            'id_unit_kerja' => $request->id_unit_kerja
        ]);

        return response()->json([
            'responCode' => 1,
            'respon' => 'Data Sukses Disimpan'
        ]);
    }

    public function updateStatusDokumen(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $user = Dokumen::find($request->id);
            $data = $user->update([
                'status' => $request->status
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
        // Mencari data Dokumen berdasarkan ID
        $dokumen = Dokumen::find($request->id);

        // Cek jika data Dokumen ditemukan
        if ($dokumen) {
            // Mendapatkan path file dokumen yang disimpan
            $filePath = public_path('dokumen/' . $dokumen->dokumen);

            // Menghapus file dari folder 'dokumen' jika ada
            if (file_exists($filePath)) {
                unlink($filePath); // Menghapus file
            }

            // Menghapus data dokumen dari database
            $dokumen->delete();

            // Response sukses setelah menghapus file dan data
            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Dihapus'
            ];
        } else {
            // Response jika dokumen tidak ditemukan
            $data = [
                'responCode' => 0,
                'respon' => 'Dokumen tidak ditemukan'
            ];
        }

        return response()->json($data);
    }
}
