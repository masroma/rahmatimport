<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasPerkuliahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas_perkuliahans', function (Blueprint $table) {
            $table->id();
            $table->integer('programstudy_id');
            $table->integer('semester_id');
            $table->integer('matakuliah_id');
            $table->string('nama_kelas');
            $table->string('lingkup')->nullable();
            $table->integer('mode_kuliah')->nullable();
            $table->date('tanggal_mulai_kuliah')->nullable();
            $table->date('tanggal_akhir_kuliah')->nullable();
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
        Schema::dropIfExists('kelas_perkuliahans');
    }
}
