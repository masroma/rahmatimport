<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstansiKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substansi_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sunstansi');
            $table->integer('programstudy_id');
            $table->integer('bobot_mata_kuliah');
            $table->integer('bobot_tatap_muka');
            $table->integer('bobot_pratikum');
            $table->integer('bobot_praktek_lapangan');
            $table->integer('bobot_simulasi');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('substansi_kuliahs');
    }
}
