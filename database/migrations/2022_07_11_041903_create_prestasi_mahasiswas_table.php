<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestasiMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestasi_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->integer('mahasiswa_id');
            $table->integer('aktivitasmahasiswa_id');
            $table->integer('jenisprestasi_id');
            $table->integer('tingkatprestasi_id');
            $table->string('nama_prestasi');
            $table->string('tahun_prestasi');
            $table->string('penyelenggara');
            $table->string('peringkat');
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
        Schema::dropIfExists('prestasi_mahasiswas');
    }
}
