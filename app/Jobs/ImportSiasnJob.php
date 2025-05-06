<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\ErrorImport;
use App\Models\Profil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DateTime;

class ImportSiasnJob implements ShouldQueue
{
    // use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // use InteractsWithQueue, Queueable, SerializesModels;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        $spreadsheet = IOFactory::load(storage_path('app/' . $this->filePath));
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $pangkatMapping = [
            'I/a' => 'I/a - Juru Muda Tingkat I',
            'I/b' => 'I/b - Juru Muda Tingkat II',
            'I/c' => 'I/c - Juru',
            'I/d' => 'I/d - Juru Tingkat I',
            'II/a' => 'II/a - Pengatur Muda',
            'II/b' => 'II/b - Pengatur Muda Tingkat I',
            'II/c' => 'II/c - Pengatur',
            'II/d' => 'II/d - Pengatur Tingkat I',
            'III/a' => 'III/a - Penata Muda',
            'III/b' => 'III/b - Penata Muda Tingkat I',
            'III/c' => 'III/c - Penata',
            'III/d' => 'III/d - Penata Tingkat I',
            'IV/a' => 'IV/a - Pembina',
            'IV/b' => 'IV/b - Pembina Tingkat I - Pembina Tk.I',
            'IV/c' => 'IV/c - Pembina Utama Muda',
            'IV/d' => 'IV/d - Pembina Utama Madya',
            'IV/e' => 'IV/e - Pembina Utama',
            'VII' => 'VII',
            'IX' => 'IX',
            'X' => 'X',
            'XI' => 'XI',
        ];

        foreach ($rows as $index => $row) {
            if ($index == 1)
                continue;

            if (empty(trim($row['B'])) && empty(trim($row['O'])) && empty(trim($row['P'])) && empty(trim($row['Q']))) {
                continue;
            }

            try {
                $nik = ltrim(trim($row['O']), "'");

                DB::table('pegawai_imports')->updateOrInsert(
                    ['nik' => $nik], // kondisi pencocokan
                    [
                        'name' => trim($row['D']) ?: 'Nama Kosong',
                        // 'email' => $row['Q'] ?? '-',
                        'no_wa' => $row['P'] ?? '-',
                        'nip' => ltrim(trim($row['B']), "'"),
                        // 'nama' => trim($row['D']) ?: 'Nama Kosong',
                        'jenis_kelamin' => trim($row['J']) == 'M' ? 'Laki-laki' : 'Perempuan',
                        'tempat_lahir' => trim($row['H']),
                        'tanggal_lahir' => date('Y-m-d', strtotime(trim($row['I']))),
                        'alamat' => trim($row['S']),
                        'agama' => trim($row['L']),
                        'status_kawin' => trim($row['N']),
                        'gelar_depan' => trim($row['E']),
                        'gelar_belakang' => trim($row['F']),
                        'tingkat_pendidikan' => trim($row['AU']),
                        'tahun_lulus' => trim($row['AX']),
                        'jurusan_pendidikan' => trim($row['AW']),
                        'npwp' => trim($row['T']),
                        'bpjs' => trim($row['U']),
                        'pangkat' => $pangkatMapping[trim($row['AK'])] ?? trim($row['AK']),
                        'jabatan' => trim($row['AR']),
                        'email_gov' => trim($row['R']),
                        'email' => trim($row['Q']),
                        // 'no_wa' => trim($row['P']),
                        'jenis_pegawai' => trim($row['W']),
                        'kedudukan_hukum' => trim($row['Y']),
                        'status_cpns' => trim($row['Z']),
                        'kartu_asn_virtual' => trim($row['AA']),
                        'nomor_sk_cpns' => trim($row['AB']),
                        'tanggal_sk_cpns' => date('Y-m-d', strtotime(trim($row['AC']))),
                        'tmt_cpns' => date('Y-m-d', strtotime(trim($row['AD']))),
                        'nomor_sk_pns' => trim($row['AE']),
                        'tanggal_sk_pns' => date('Y-m-d', strtotime(trim($row['AF']))),
                        'tmt_pns' => date('Y-m-d', strtotime(trim($row['AG']))),
                        'tmt_golongan' => date('Y-m-d', strtotime(trim($row['AL']))),
                        'mk_tahun' => trim($row['AM']),
                        'mk_bulan' => trim($row['AN']),
                        'jenis_jabatan' => trim($row['AP']),
                        'kpkn' => trim($row['AZ']),
                        'lokasi_kerja' => trim($row['BB']),
                        'unor' => trim($row['BD']),
                        'instansi_induk' => trim($row['BF']),
                        'instansi_kerja' => trim($row['BH']),
                        'satuan_kerja' => trim($row['BJ']),
                        'status_input' => 'Import',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
            } catch (\Exception $e) {
                \Log::error('Gagal import baris ke ' . $index . ': ' . $e->getMessage());

                ErrorImport::create([
                    'keterangan' => 'Gagal import baris ke ' . $index . ': ' . $e->getMessage()
                ]);
            }
        }
    }

}
