<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenPenugasansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_penugasans', function (Blueprint $table) {
            $table->id();
            $table->integer('dosen_id');
            $table->integer('kampus_id');
            $table->integer('jurusan_id');
            $table->integer('tahunajaran_id');
            $table->string('no_surat_tugas');
            $table->date('tanggal_surat_tugas');
            $table->date('TMT_surat_tugas');
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
        Schema::dropIfExists('dosen_penugasans');
    }
}
