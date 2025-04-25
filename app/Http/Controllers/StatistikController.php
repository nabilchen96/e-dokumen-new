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

class StatistikController extends Controller
{
    public function index()
    {

        $s3 = DB::table('profils')->where('tingkat_pendidikan', 'S3')->count();
        $s2 = DB::table('profils')->where('tingkat_pendidikan', 'S2')->count();
        $s1 = DB::table('profils')->where('tingkat_pendidikan', 'S1/Diploma IV')->count();
        $sma = DB::table('profils')->where('tingkat_pendidikan', 'SMA Sederajat')->count();
        $d1 = DB::table('profils')->where('tingkat_pendidikan', 'Diploma I')->count();
        $d2 = DB::table('profils')->where('tingkat_pendidikan', 'Diploma II')->count();
        $d3 = DB::table('profils')->where('tingkat_pendidikan', 'Diploma III')->count();

        return view('backend.statistik.index', [
            's3' => $s3,
            's2' => $s2,
            's1' => $s1,
            'sma' => $sma,
            'd1' => $d1,
            'd2' => $d2,
            'd3' => $d3
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
            ->get();

        return response()->json($data);
    }

    public function dataSkpd()
    {

        $data = DB::table('dokumens')
            ->join('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
            ->leftjoin('users', 'users.id', '=', 'dokumens.id_user')
            ->leftjoin('profils', 'profils.id_user', '=', 'users.id')
            ->select(
                'skpds.nama_skpd',
                // DB::raw('COUNT(DISTINCT dokumens.id_user) as total')
                'skpds.id as id_skpd',
                DB::raw("SUM(CASE WHEN profils.jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki_laki"),
                DB::raw("SUM(CASE WHEN profils.jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan")
            )
            ->whereIn('dokumens.id', function ($query) {
                // Select the latest dokumen per user
                $query->selectRaw('MAX(dokumens.id)')
                    ->from('dokumens')
                    ->groupBy('dokumens.id_user');
            })
            ->groupBy('skpds.id')
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
            ->groupBy('umur')
            ->havingRaw('umur BETWEEN 17 AND 70') // 👈 filter umur
            ->orderBy('umur')
            ->get();

        return response()->json($data);

    }
    public function detailPendidikan()
    {

        $data = DB::table('users')
            ->leftjoin('profils', 'profils.id_user', '=', 'users.id')
            ->leftjoin('dokumens', 'dokumens.id_user', '=', 'users.id')
            ->leftjoin('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
            ->where('profils.tingkat_pendidikan', Request('pendidikan'))
            ->select(
                'users.name',
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
            ->whereNotIn('status_pegawai', ['Honorer'])
            ->get();

        $title = 'Pencarian Berdasarkan Lulusan ' . Request('pendidikan');

        return view('backend.statistik.detail', [
            'data' => $data,
            'title' => $title
        ]);
    }

    public function detailSkpd()
    {
        // Periksa apakah ada nilai umur yang diberikan di URL atau form
        $data = DB::table('users')
            ->leftjoin('profils', 'profils.id_user', '=', 'users.id')
            ->leftjoin('dokumens', 'dokumens.id_user', '=', 'users.id')
            ->leftjoin('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
            ->where('skpds.id', Request('id_skpd'))
            ->select(
                'users.name',
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
            ->whereNotIn('status_pegawai', ['Honorer'])
            ->get();

        $title = 'Pencarian Berdasarkan SKPD ' . Request('skpd');

        return view('backend.statistik.detail', [
            'data' => $data,
            'title' => $title
        ]);
    }

    public function importExcel(Request $request)
    {
        // Validasi input file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $successCount = 0;
        $failCount = 0;

        foreach ($rows as $index => $row) {
            if ($index == 1)
                continue;

            if (empty(trim($row['A'])) && empty(trim($row['B'])) && empty(trim($row['C'])) && empty(trim($row['D']))) {
                continue;
            }

            $user = null;

            // Cek berdasarkan NIP
            $profil = Profil::where('nip', trim($row['C']))->first();
            if ($profil) {
                $user = $profil->user;
            }

            // Jika belum ditemukan, cek berdasarkan NIK
            if (!$user && !$profil) {
                $profil = Profil::where('nik', trim($row['B']))->first();
                if ($profil) {
                    $user = $profil->user;
                }
            }

            // Jika belum ditemukan, cek berdasarkan email atau no_wa
            if (!$user) {
                $user = User::where('email', trim($row['D']))
                    ->orWhere('no_wa', trim($row['E']))
                    ->first();
            }

            // Jika tetap tidak ditemukan, gagal
            if (!$user) {
                $failCount++;
                continue;
            }

            // dd($user);

            try {
                // Update data user
                // $user->update([
                //     'name' => trim($row['A']),
                //     'email' => trim($row['B']),
                //     'no_wa' => trim($row['C']),
                //     'password' => Hash::make(trim($row['D'])),
                // ]);

                // Update atau buat profil jika belum ada

                if ($profil) {
                    DB::table('profils')->where('id_user', $user->id)->update([
                        'nik' => trim($row['B']),
                        'nip' => trim($row['C']),
                        'jenis_kelamin' => trim($row['F']),
                        'tempat_lahir' => trim($row['G']),
                        'tanggal_lahir' => trim($row['H']),
                        'alamat' => trim($row['I']),
                        'agama' => trim($row['J']),
                        'status_kawin' => trim($row['K']),
                        'gelar_depan' => trim($row['L']),
                        'gelar_belakang' => trim($row['M']),
                        'tingkat_pendidikan' => trim($row['N']),
                        'tahun_lulus' => trim($row['O']),
                        'jurusan_pendidikan' => trim($row['P']),
                        'npwp' => trim($row['Q']),
                        'bpjs' => trim($row['R']),
                        'pangkat' => trim($row['S']),
                        'jabatan' => trim($row['T']),
                        'email_gov' => trim($row['U']),
                        'jenis_pegawai' => trim($row['V']),
                        'kedudukan_hukum' => trim($row['W']),
                        'status_cpns' => trim($row['X']),
                        'kartu_asn_virtual' => trim($row['Y']),
                        'nomor_sk_cpns' => trim($row['Z']),
                        'tanggal_sk_cpns' => trim($row['AA']),
                        'tmt_cpns' => trim($row['AB']),
                        'nomor_sk_pns' => trim($row['AC']),
                        'tanggal_sk_pns' => trim($row['AD']),
                        'tmt_pns' => trim($row['AE']),
                        'tmt_golongan' => trim($row['AF']),
                        'mk_tahun' => trim($row['AG']),
                        'mk_bulan' => trim($row['AH']),
                        'jenis_jabatan' => trim($row['AI']),
                        'kpkn' => trim($row['AJ']),
                        'lokasi_kerja' => trim($row['AK']),
                        'unor' => trim($row['AL']),
                        'instansi_induk' => trim($row['AM']),
                        'instansi_kerja' => trim($row['AN']),
                        'satuan_kerja' => trim($row['AO']),
                    ]);
                } else {
                    // Jika profil belum ada tapi user ditemukan, skip saja (gagal)
                    $failCount++;
                    continue;
                }

                $successCount++;
            } catch (\Exception $e) {

                dd($e);

                $failCount++;
            }
        }

        return response()->json([
            'message' => 'Proses import selesai.',
            'success_count' => $successCount,
            'fail_count' => $failCount
        ]);
    }

}
