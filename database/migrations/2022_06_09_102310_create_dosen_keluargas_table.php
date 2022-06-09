<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenKeluargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_keluargas', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('dosen_id');
            $table->enum('status_pernikahan',['belum menikah','sudah menikah','bercerai'])->nullable();
            $table->string('nama_pasangan')->nullable();
            $table->string('nip_pasangan')->nullable();
            $table->string('tmt_pasangan')->nullable();
            $table->string('pekerjaan')->nullable();
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
        Schema::dropIfExists('dosen_keluargas');
    }
}
