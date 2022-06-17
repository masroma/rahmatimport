<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKurikulumMatakuliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurikulum_matakulians', function (Blueprint $table) {
            $table->id();
            $table->integer('matakuliah_id');
            $table->integer('kurikulum_id');
            $table->integer('semester')->nullable();
            $table->enum('wajib',['y','n'])->nullable();
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
        Schema::dropIfExists('kurikulum_matakulians');
    }
}
