<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_matakuliah')->unique()->nullable();
            $table->string('nama_matakuliah');
            $table->integer('programstudy_id');
            $table->string('jenis_mata_kuliah');
            $table->BigInteger('bobot_mata_kuliah');
            $table->BigInteger('bobot_tatap_muka');
            $table->BigInteger('bobot_pratikum');
            $table->BigInteger('bobot_praktek_lapanagn');
            $table->BigInteger('bobot_simulasi');
            $table->string('metode_pembelajaran');
            $table->date('tanggal_mulai_efektif');
            $table->date('tanggal_akhir_efektif');
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mata_kuliahs');
    }
}
