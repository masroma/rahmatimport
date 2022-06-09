<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenPembimbingAktifitasMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_aktifitas_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dosen_id');
            $table->enum('type',['pembimbing','penguji'])->nullable();
            $table->integer('mahasiswa_id')->nullable();
            $table->string('jenis_aktivitas')->nullable();
            $table->string('judul_aktivitas')->nullable();
            $table->date('tanggal_aktivitas')->nullable();
            $table->string('urutan')->nullable();
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
        Schema::dropIfExists('dosen_pembimbing_aktifitas_mahasiswas');
    }
}
