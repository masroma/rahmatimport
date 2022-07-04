<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenPengujiAktivitasMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_penguji_aktivitas_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->integer('aktivitasmahasiswa_id');
            $table->integer('dosen_id');
            $table->integer('order');
            $table->integer('kategorikegiatan_id');
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
        Schema::dropIfExists('dosen_penguji_aktivitas_mahasiswas');
    }
}
