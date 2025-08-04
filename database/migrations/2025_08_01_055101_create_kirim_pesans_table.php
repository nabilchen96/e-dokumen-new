<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKirimPesansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kirim_pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pesan'); //generate otomatis unik
            $table->text('pesan');
            $table->string('nomor_tujuan');
            $table->string('id_user');
            $table->string('id_pengirim');
            $table->string('status');
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
        Schema::dropIfExists('kirim_pesans');
    }
}
