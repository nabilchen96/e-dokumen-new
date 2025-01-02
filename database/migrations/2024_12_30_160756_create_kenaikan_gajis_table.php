<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKenaikanGajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kenaikan_gajis', function (Blueprint $table) {
            $table->id();
            $table->string('id_profil'); //nama lengkap //tanggal lahir //nip
            $table->string('pangkat')->nullable();
            $table->string('jabatan')->nullable();
            $table->date('tgl_dokumen')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('skpd')->nullable();
            $table->integer('gaji_pokok_lama')->nullable();
            $table->string('oleh_pejabat')->nullable();
            $table->date('tgl_dokumen_sebelumnya')->nullable();
            $table->string('no_dokumen_sebelumnya')->nullable();
            $table->date('tgl_berlaku_gaji')->nullable();
            $table->string('masa_kerja_tahun_sebelumnya')->nullable();
            $table->string('masa_kerja_bulan_sebelumnya')->nullable();
            $table->integer('gaji_pokok_baru')->nullable();
            $table->string('masa_kerja_tahun_baru')->nullable();
            $table->string('masa_kerja_bulan_baru')->nullable();
            $table->string('golongan')->nullable();
            $table->date('tgl_terhitung_mulai')->nullable();
            $table->date('tgl_kenaikan_berikutnya')->nullable();
            $table->integer('id_profil_kepala')->nullable();
            $table->integer('golongan_kepala')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kenaikan_gajis');
    }
}
