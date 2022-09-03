<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiKampusMerdekasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_kampus_merdekas', function (Blueprint $table) {
            $table->id();
            $table->integer('aktivitas_id');
            $table->integer('matakuliah_id');
            $table->integer('mahasiswa_id');
            $table->float('nilai_angka');
            $table->string('nilai_huruf');
            $table->string('index');
            $table->softDeletes();
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
        Schema::dropIfExists('nilai_kampus_merdekas');
    }
}
