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
            // ... [keep your existing pangkat mappings] ...
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

                // Enhanced date handling function
                $parseDate = function ($rawDate) {
                    if (empty(trim($rawDate)))
                        return null;

                    // If it's already a DateTime object (from PhpSpreadsheet)
                    if ($rawDate instanceof \DateTime) {
                        return $rawDate->format('Y-m-d');
                    }

                    // If it's Excel serial number
                    if (is_numeric($rawDate)) {
                        return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rawDate)->format('Y-m-d');
                    }

                    // Clean the date string
                    $cleanedDate = preg_replace('/[^0-9\/-]/', '', trim($rawDate));

                    // Try multiple date formats
                    $formats = ['d/m/Y', 'm/d/Y', 'Y-m-d', 'd-m-Y'];
                    foreach ($formats as $format) {
                        $date = \DateTime::createFromFormat($format, $cleanedDate);
                        if ($date) {
                            return $date->format('Y-m-d');
                        }
                    }

                    \Log::warning("Failed to parse date: " . $rawDate);
                    return null;
                };

                DB::table('pegawai_imports')->updateOrInsert(
                    ['nik' => $nik],
                    [
                        'name' => trim($row['D']) ?: 'Nama Kosong',
                        'no_wa' => $row['P'] ?? '-',
                        'nip' => ltrim(trim($row['B']), "'"),
                        'jenis_kelamin' => trim($row['J']) == 'M' ? 'Laki-laki' : 'Perempuan',
                        'tempat_lahir' => trim($row['H']),
                        'tanggal_lahir' => $parseDate($row['I']),
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
                        'jenis_pegawai' => trim($row['W']),
                        'kedudukan_hukum' => trim($row['Y']),
                        'status_cpns' => trim($row['Z']),
                        'kartu_asn_virtual' => trim($row['AA']),
                        'nomor_sk_cpns' => trim($row['AB']),
                        'tanggal_sk_cpns' => $parseDate($row['AC']),
                        'tmt_cpns' => $parseDate($row['AD']),
                        'nomor_sk_pns' => trim($row['AE']),
                        'tanggal_sk_pns' => $parseDate($row['AF']),
                        'tmt_pns' => $parseDate($row['AG']),
                        'tmt_golongan' => $parseDate($row['AL']),
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
