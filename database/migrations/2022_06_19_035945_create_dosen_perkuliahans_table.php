<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenPerkuliahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_perkuliahans', function (Blueprint $table) {
            $table->id();
            $table->integer('kelasperkuliahan_id');
            $table->integer('dosen_id');
            $table->integer('substansi_id')->nullable();
            $table->integer('bobot_sks');
            $table->integer('jumlah_rencana_pertemuan');
            $table->integer('jumlah_realisasi_pertemuan')->nullable();
            $table->string('jenis_evaluasi');
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
        Schema::dropIfExists('dosen_perkuliahans');
    }
}
