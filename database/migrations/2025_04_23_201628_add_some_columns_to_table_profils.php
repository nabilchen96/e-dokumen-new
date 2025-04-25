<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsToTableProfils extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profils', function (Blueprint $table) {
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('agama')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('email_gov')->nullable();
            $table->string('npwp')->nullable();
            $table->string('bpjs')->nullable();
            $table->string('jenis_pegawai')->nullable();
            $table->string('kedudukan_hukum')->nullable();
            $table->string('status_cpns')->nullable();
            $table->string('kartu_asn_virtual')->nullable();

            //CPNS
            $table->string('nomor_sk_cpns')->nullable();
            $table->date('tanggal_sk_cpns')->nullable();
            $table->date('tmt_cpns')->nullable();

            //PNS
            $table->string('nomor_sk_pns')->nullable();
            $table->date('tanggal_sk_pns')->nullable();
            $table->date('tmt_pns')->nullable();

            //GOLONGAN AWAL, GOLONGAN SUDAH ADA KITA BUAT SEBAGAI
            //GOLONGAN AKHIR ATAU GOLONGAN SAAT INI

            $table->date('tmt_golongan')->nullable();
            $table->string('mk_tahun')->nullable();
            $table->string('mk_bulan')->nullable();
            $table->string('jenis_jabatan')->nullable();

            //PENDIDIKAN
            $table->string('tingkat_pendidikan')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->string('jurusan_pendidikan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profils', function (Blueprint $table) {
            //
        });
    }
}
