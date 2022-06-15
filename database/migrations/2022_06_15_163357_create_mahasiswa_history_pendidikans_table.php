<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaHistoryPendidikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_history_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->integer('jenis_pendaftaran');
            $table->integer('jalur_pendaftaran');
            $table->integer('periode_pendaftaran');
            $table->date('tanggal_masuk');
            $table->integer('pembiayaan_awal');
            $table->biginteger('biaya_masuk');
            $table->integer('kampus_id');
            $table->integer('programstudy_id');
            $table->integer('perminatan_id')->nullable();
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
        Schema::dropIfExists('mahasiswa_history_pendidikans');
    }
}
