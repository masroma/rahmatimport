<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_dosens', function (Blueprint $table) {
            $table->id();
            $table->integer('ruangperkuliahan_id');
            $table->integer('dosen_id');
            $table->integer('pertemuan_ke')->default(0);
            $table->string("jenis_pertemuan");
            $table->string('tema');
            $table->string('pokok_bahasan');
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
        Schema::dropIfExists('absensi_dosens');
    }
}
