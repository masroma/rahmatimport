<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dosen_id');
            $table->string('nik')->unique();
            $table->string('nip')->nullable();
            $table->string('npwp')->nullable();
            $table->string('telephone')->nullable();
            $table->string('handphone')->nullable();
            $table->string('email')->nullable();
            $table->string('ikatan_kerja')->nullable();
            $table->string('status_pegawai')->nullable();
            $table->string('jenis_pegawai')->nullable();
            $table->string('no_sk_cpns')->nullable();
            $table->date('tanggal_sk_cpns')->nullable();
            $table->string('no_sk_pengangkatan')->nullable();
            $table->string('tanggal_sk_pengangkatan')->nullable();
            $table->string('lembaga_pengangkatan')->nullable();
            $table->string('pangkat_golongan')->nullable();
            $table->string('sumber_lainya')->nullable();
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
        Schema::dropIfExists('dosen_details');
    }
}
