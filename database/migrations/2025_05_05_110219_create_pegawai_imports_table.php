<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_imports', function (Blueprint $table) {
            $table->id();

            $table->string('name'); //awalnya id_user

            $table->string('email');
            $table->string('no_wa');

            $table->string('nip')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('district_id')->nullable();
            $table->string('alamat')->nullable();

            $table->string('status_pegawai')->default('PNS');

            $table->string('pangkat')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('golongan')->nullable();

            $table->string('nik')->nullable();

            $table->string('id_unit_kerja')->nullable();

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

            $table->string('kpkn')->nullable();
            $table->string('lokasi_kerja')->nullable();
            $table->string('unor')->nullable();
            $table->string('instansi_induk')->nullable();
            $table->string('instansi_kerja')->nullable();
            $table->string('satuan_kerja')->nullable();

            $table->string('status_input')->nullable();
            $table->timestamps();

            //TABEL PROFILS 47
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai_imports');
    }
}
