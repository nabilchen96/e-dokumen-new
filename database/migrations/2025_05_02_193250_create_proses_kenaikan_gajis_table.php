<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProsesKenaikanGajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proses_kenaikan_gajis', function (Blueprint $table) {
            $table->id();
            //0. USER OPD
            $table->string('file_pengantar')->nullable();
            $table->string('id_user_0')->nullable();
            $table->dateTime('waktu_0')->nullable();

            //1. USER STAFF BKPSDM
            $table->string('id_user_1')->nullable();
            $table->string('status_1')->nullable();
            $table->dateTime('waktu_1')->nullable();
            $table->text('keterangan_1')->nullable();

            //2. USER KABID BKPSDM
            $table->string('id_user_2')->nullable();
            $table->string('status_2')->nullable();
            $table->dateTime('waktu_2')->nullable();
            $table->text('keterangan_2')->nullable();

            //3. USER SEKRETARIS BKPSDM
            $table->string('id_user_3')->nullable();
            $table->string('status_3')->nullable();
            $table->dateTime('waktu_3')->nullable();
            $table->text('keterangan_3')->nullable();

            //4. USER KEPALA BKPSDM
            $table->string('id_user_4')->nullable();
            $table->string('status_4')->nullable();
            $table->dateTime('waktu_4')->nullable();
            $table->text('keterangan_4')->nullable();

            //5. USER BENDAHARA GAJI DPKAD
            $table->string('id_user_5')->nullable();
            $table->string('status_5')->nullable();
            $table->dateTime('waktu_5')->nullable();
            $table->text('keterangan_5')->nullable();

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
        Schema::dropIfExists('proses_kenaikan_gajis');
    }
}
