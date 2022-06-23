<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuangPerkuliahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruang_perkuliahans', function (Blueprint $table) {
            $table->id();
            $table->integer('kelasperkuliahan_id');
            $table->integer('ruang_id');
            $table->string('kode')->nullable();
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_akhir');
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
        Schema::dropIfExists('ruang_perkuliahans');
    }
}
