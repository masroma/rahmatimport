<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_pertemuan_kelas', function (Blueprint $table) {
            $table->id();
            $table->integer('ruangperkuliahan_id');
            $table->integer('mahasiswa_id');
            $table->integer('pertemuan_1')->default(0);
            $table->integer('pertemuan_2')->default(0);
            $table->integer('pertemuan_3')->default(0);
            $table->integer('pertemuan_4')->default(0);
            $table->integer('pertemuan_5')->default(0);
            $table->integer('pertemuan_6')->default(0);
            $table->integer('pertemuan_7')->default(0);
            $table->integer('pertemuan_8')->default(0);
            $table->integer('pertemuan_9')->default(0);
            $table->integer('pertemuan_10')->default(0);
            $table->integer('pertemuan_11')->default(0);
            $table->integer('pertemuan_12')->default(0);
            $table->integer('pertemuan_13')->default(0);
            $table->integer('pertemuan_14')->default(0);
            $table->integer('pertemuan_15')->default(0);
            $table->integer('pertemuan_16')->default(0);
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
        Schema::dropIfExists('absensi_kelas');
    }
}
