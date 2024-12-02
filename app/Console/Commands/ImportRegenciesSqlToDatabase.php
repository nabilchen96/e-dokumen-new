<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportRegenciesSqlToDatabase extends Command
{
    protected $signature = 'import:RegenciesSql';
    protected $description = 'Import Regencies SQL to Database';

    public function handle()
    {
        // Path file SQL
        $filePath = public_path('regencies.sql');

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            $this->error('File SQL tidak ditemukan!');
            return 1;
        }

        // Baca isi file SQL
        $sql = file_get_contents($filePath);

        // Jalankan SQL melalui DB::unprepared
        try {
            DB::unprepared($sql);
            $this->info('File SQL berhasil diimpor ke database.');
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
