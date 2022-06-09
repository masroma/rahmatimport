<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenRiwayatSertifikasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_riwayat_sertifikasis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dosen_id');
            $table->string('no_peserta')->nullable();
            $table->string('bidang_study')->nullable();
            $table->string('jenis_sertifikasi')->nullable();
            $table->string('tahun_sertifikasi')->nullable();
            $table->string('no_sk_sertifikasi')->nullable();
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
        Schema::dropIfExists('dosen_riwayat_sertifikasis');
    }
}
