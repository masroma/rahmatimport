<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCutLockTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cut_lock_times', function (Blueprint $table) {
            $table->id();
            $table->enum('key',['krs','input_nilai']);
            $table->integer('tahunajaran_id');
            $table->date('start_tanggal')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_tanggal')->nullable();
            $table->time('end_time')->nullable();
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
        Schema::dropIfExists('cut_lock_times');
    }
}
