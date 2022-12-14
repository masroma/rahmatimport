<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiPerkuliahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_perkuliahans', function (Blueprint $table) {
            $table->id();
            $table->integer('kelas_id');
            $table->integer('mahasiswa_id');
            $table->integer('nilai_angka')->default(0);
            $table->string('nilai_huruf')->nullable();
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
        Schema::dropIfExists('nilai_perkuliahans');
    }
}
