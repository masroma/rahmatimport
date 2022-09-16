<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeptKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pept_kelas', function (Blueprint $table) {
            $table->id();
            $table->integer('jenissemester_id');
            $table->integer("peptbatch_id");
            $table->date("tanggal_pelaksanaan");
            $table->date("tanggal_selesai_pelaksanaan");
            $table->string("nama_kelas");
            $table->integer("ruang_id");
            $table->integer("maksimal_peserta");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pept_kelas');
    }
}
