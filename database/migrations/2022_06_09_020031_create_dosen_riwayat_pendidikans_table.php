<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenRiwayatPendidikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_riwayat_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dosen_id');
            $table->string('bidang_study')->nullable();
            $table->string('jenjang')->nullable();
            $table->string('gelar')->nullable();
            $table->string('perguruan_tinggi')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->BigInteger('sks')->nullable();
            $table->string('ipk')->nullable();
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
        Schema::dropIfExists('dosen_riwayat_pendidikans');
    }
}
