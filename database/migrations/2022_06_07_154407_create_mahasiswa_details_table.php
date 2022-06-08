<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mahasiswa_id');
            $table->bigInteger('kewarganegaraan_id');
            $table->string('nisn');
            $table->string('email')->nullable();
            $table->string('ktp');
            $table->string('npwp')->nullable();
            $table->text('jalan')->nullable();
            $table->string('telephone')->nullable();
            $table->string('dusun')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('handphone')->nullable();
            $table->enum('penerima_kps',['y','n'])->nullable();
            $table->bigInteger('province_id')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('district_id')->nullable();
            $table->bigInteger('village_id')->nullable();
            $table->string('jenis_tinggal')->nullable();
            $table->string('alat_transportasi')->nullable();
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
        Schema::dropIfExists('mahasiswa_details');
    }
}
