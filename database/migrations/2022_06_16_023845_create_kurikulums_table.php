<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKurikulumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurikulums', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kurikulum');
            $table->integer('jumlah_bobot_mata_kuliah_pilihan');
            $table->integer('programstudy_id');
            $table->integer('masa_berlaku');
            $table->integer('jumlah_sks');
            $table->integer('jumlah_bobot_mata_kuliah_wajib');
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
        Schema::dropIfExists('kurikulums');
    }
}
