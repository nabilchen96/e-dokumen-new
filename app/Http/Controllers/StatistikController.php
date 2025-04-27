<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ImportSiasnJob;

class StatistikController extends Controller
{
    public function index()
    {

        $s3 = DB::table('profils')
            ->where('tingkat_pendidikan', 'S-3/Doktor')
            ->where('status_input', 'Import')
            ->count();

        $s2 = DB::table('profils')
            ->where('tingkat_pendidikan', 'S-2')
            ->where('status_input', 'Import')
            ->count();

        $s1 = DB::table('profils')
            ->where('tingkat_pendidikan', 'S-1/Sarjana')
            ->where('status_input', 'Import')
            ->count();


        $d1 = DB::table('profils')
            ->where('tingkat_pendidikan', 'Diploma I')
            ->where('status_input', 'Import')
            ->count();

        $d2 = DB::table('profils')
            ->where('tingkat_pendidikan', 'Diploma II')
            ->where('status_input', 'Import')
            ->count();

        $d3 = DB::table('profils')
            ->where('tingkat_pendidikan', 'Diploma III/Sarjana Muda')
            ->where('status_input', 'Import')
            ->count();

        $d4 = DB::table('profils')
            ->where('tingkat_pendidikan', 'Diploma IV')
            ->where('status_input', 'Import')
            ->count();

        $sma = DB::table('profils')
            ->where('tingkat_pendidikan', 'SLTA')
            ->orwhere('tingkat_pendidikan', 'SLTA Kejuruan')
            ->where('status_input', 'Import')
            ->count();

        return view('backend.statistik.index', [
            's3' => $s3,
            's2' => $s2,
            's1' => $s1,
            'sma' => $sma,
            'd1' => $d1,
            'd2' => $d2,
            'd3' => $d3,
            'd4' => $d4
        ]);
    }

    public function dataPendidikan()
    {

        $data = DB::table('profils')
            ->select(
                'tingkat_pendidikan',
                DB::raw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki_laki"),
                DB::raw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan")
            )
            ->groupBy('tingkat_pendidikan')
            ->whereNotIn('status_pegawai', ['Honorer'])
            ->whereNotNull('tingkat_pendidikan')
            ->where('profils.status_input', 'Import')
            ->get();

        return response()->json($data);
    }

    public function dataJenisKelamin()
    {

        $data = DB::table('profils')
            ->select(
                'jenis_kelamin',
                DB::raw('count(jenis_kelamin) as total')
            )
            ->groupBy('jenis_kelamin')
            ->whereNotNull('jenis_kelamin')
            ->whereNotIn('status_pegawai', ['Honorer'])
            ->where('profils.status_input', 'Import')
            ->get();

        return response()->json($data);
    }

    public function dataJenisJabatan()
    {

        $data = DB::table('profils')
            ->select(
                'jenis_jabatan',
                DB::raw('count(jenis_jabatan) as total')
            )
            ->groupBy('jenis_jabatan')
            ->whereNotNull('jenis_jabatan')
            ->where('profils.status_input', 'Import')
            ->get();

        // $data = DB::table('profils')
        //     ->select(
        //         DB::raw("COALESCE(jenis_jabatan, 'Lainnya') as jenis_jabatan"),
        //         DB::raw('count(*) as total')
        //     )
        //     ->groupBy(DB::raw("COALESCE(jenis_jabatan, 'Lainnya')"))
        //     ->get();

        return response()->json($data);
    }

    public function dataPangkat()
    {

        $data = DB::table('profils')
            ->select(
                'pangkat',
                DB::raw("SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki_laki"),
                DB::raw("SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan")
            )
            ->groupBy('pangkat')
            ->whereNotIn('status_pegawai', ['Honorer'])
            ->whereNotNull('pangkat')
            ->where('profils.status_input', 'Import')
            ->get();

        return response()->json($data);
    }

    public function dataSkpd()
    {

        // $data = DB::table('dokumens')
        //     ->join('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
        //     ->leftjoin('users', 'users.id', '=', 'dokumens.id_user')
        //     ->leftjoin('profils', 'profils.id_user', '=', 'users.id')
        //     ->select(
        //         'skpds.nama_skpd',
        //         // DB::raw('COUNT(DISTINCT dokumens.id_user) as total')
        //         'skpds.id as id_skpd',
        //         DB::raw("SUM(CASE WHEN profils.jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki_laki"),
        //         DB::raw("SUM(CASE WHEN profils.jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan")
        //     )
        //     ->whereIn('dokumens.id', function ($query) {
        //         // Select the latest dokumen per user
        //         $query->selectRaw('MAX(dokumens.id)')
        //             ->from('dokumens')
        //             ->groupBy('dokumens.id_user');
        //     })
        //     ->groupBy('skpds.id')
        //     ->where('profils.status_input', 'Import')
        //     ->whereNotIn('profils.status_pegawai', ['Honorer'])
        //     ->get();

        $data = DB::table('profils')
            ->join('users', 'users.id', '=', 'profils.id_user')
            ->select(
                'profils.unor as nama_skpd',
                DB::raw("SUM(CASE WHEN profils.jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki_laki"),
                DB::raw("SUM(CASE WHEN profils.jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan")
            )
            ->whereNotNull('profils.unor')
            ->groupBy('unor')
            ->where('profils.status_input', 'Import')
            ->whereNotIn('profils.status_pegawai', ['Honorer'])
            ->get();


        return response()->json($data);
    }

    public function dataUmur()
    {
        $data = DB::table('profils')
            ->selectRaw("
                TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) as umur,
                SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki_laki,
                SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan
            ")
            ->whereNotNull('tanggal_lahir')
            ->whereNotIn('status_pegawai', ['Honorer'])
            ->groupBy(DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())')) // Perbaiki groupBy
            ->havingRaw('umur BETWEEN 17 AND 70') // 👈 filter umur
            ->orderBy('umur')
            ->where('profils.status_input', 'Import')
            ->get();


        return response()->json($data);

    }
    public function detailPendidikan()
    {

        $data = DB::table('users')
            ->leftjoin('profils', 'profils.id_user', '=', 'users.id')
            ->leftjoin('dokumens', 'dokumens.id_user', '=', 'users.id')
            ->leftjoin('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
            ->select(
                'users.name',
                'users.no_wa',
                'skpds.nama_skpd',
                'profils.*',
                DB::raw("TIMESTAMPDIFF(YEAR, profils.tanggal_lahir, CURDATE()) as umur")
            )
            ->where(function ($query) {
                // Kondisi untuk mengambil dokumen terakhir atau tidak ada dokumen
                $query->whereNull('dokumens.id')  // Mengambil data tanpa dokumen
                    ->orWhereIn('dokumens.id', function ($subQuery) {
                    $subQuery->selectRaw('MAX(dokumens.id)')
                        ->from('dokumens')
                        ->groupBy('dokumens.id_user');
                });
            })
            ->where('profils.status_input', 'Import')
            ->whereNotIn('status_pegawai', ['Honorer']);

        if (Request('pendidikan') == 'SMA') {
            $data = $data->where('profils.tingkat_pendidikan', 'SLTA Kejuruan')->orWhere('profils.tingkat_pendidikan', 'SLTA')->get();
        } else {
            $data = $data->where('profils.tingkat_pendidikan', Request('pendidikan'))->get();
        }

        $title = 'Pencarian Berdasarkan Lulusan ' . Request('pendidikan');

        return view('backend.statistik.detail', [
            'data' => $data,
            'title' => $title
        ]);
    }

    public function detailSkpd()
    {
        // Periksa apakah ada nilai umur yang diberikan di URL atau form
        // $data = DB::table('users')
        //     ->leftjoin('profils', 'profils.id_user', '=', 'users.id')
        //     ->leftjoin('dokumens', 'dokumens.id_user', '=', 'users.id')
        //     ->leftjoin('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
        //     ->where('skpds.id', Request('id_skpd'))
        //     ->select(
        //         'users.name',
        //         'skpds.nama_skpd',
        //         'profils.*',
        //         DB::raw("TIMESTAMPDIFF(YEAR, profils.tanggal_lahir, CURDATE()) as umur")
        //     )
        //     ->where('profils.status_input', 'Import')
        //     ->where(function ($query) {
        //         // Kondisi untuk mengambil dokumen terakhir atau tidak ada dokumen
        //         $query->whereNull('dokumens.id')  // Mengambil data tanpa dokumen
        //             ->orWhereIn('dokumens.id', function ($subQuery) {
        //             $subQuery->selectRaw('MAX(dokumens.id)')
        //                 ->from('dokumens')
        //                 ->groupBy('dokumens.id_user');
        //         });
        //     })
        //     ->whereNotIn('status_pegawai', ['Honorer'])
        //     ->get();


        $data = DB::table('profils')
            ->join('users', 'users.id', '=', 'profils.id_user')
            ->select(
                'users.name',
                'users.no_wa',
                'profils.*',
                DB::raw("TIMESTAMPDIFF(YEAR, profils.tanggal_lahir, CURDATE()) as umur")
            )
            // ->groupBy('unor')
            ->where('profils.status_input', 'Import')
            ->whereNotIn('profils.status_pegawai', ['Honorer'])
            ->where('profils.unor', Request('nama_skpd') ?? '')
            ->get();

        $title = 'Pencarian Berdasarkan SKPD ' . Request('nama_skpd');

        return view('backend.statistik.detail', [
            'data' => $data,
            'title' => $title
        ]);
    }

    public function detailUmur()
    {

        $data = DB::table('users')
            ->leftjoin('profils', 'profils.id_user', '=', 'users.id')
            ->select(
                'users.name',
                'users.no_wa',
                'profils.*',
                DB::raw("TIMESTAMPDIFF(YEAR, profils.tanggal_lahir, CURDATE()) as umur")
            )
            ->whereRaw("TIMESTAMPDIFF(YEAR, profils.tanggal_lahir, CURDATE()) = ?", [Request('umur')])
            ->where('profils.status_input', 'Import')
            ->whereNotIn('status_pegawai', ['Honorer'])
            ->get();

        $title = 'Pencarian Berdasarkan Umur ' . Request('umur') .' Tahun';

        return view('backend.statistik.detail', [
            'data' => $data,
            'title' => $title
        ]);
    }

    public function importExcel(Request $request)
    {

        // Debugbar::disable(); // Nonaktifkan debugbar hanya di proses ini

        // ini_set('memory_limit', '1024M'); // Tambahan untuk cegah error memori
        // ini_set('max_execution_time', 1500); // Tambahan cegah timeout

        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('file')->store('imports');

        ImportSiasnJob::dispatch($path);

        return response()->json([
            'message' => 'File berhasil diunggah dan sedang diproses di background. 
            Upload data dengan ukuran besar akan memakan waktu lebih dari 10 menit. Silahkan cek secara berkala untuk melihat perubahan data.'
        ]);
    }

    public function hapusDataImport()
    {

        DB::transaction(function () {
            // Cari semua user_id dari profils yang status 'import'
            $userIds = Profil::where('status_input', 'Import')->pluck('id_user');

            // dd($userIds);

            if ($userIds->isNotEmpty()) {
                // Hapus users yang id-nya ada di daftar itu
                User::whereIn('id', $userIds)->delete();

                // Hapus profils dengan status 'import'
                Profil::where('status_input', 'Import')->delete();
            }
        });

        return back();
    }
}
