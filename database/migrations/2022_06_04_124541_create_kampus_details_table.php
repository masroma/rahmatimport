<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKampusDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kampus_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kampus_id');
            $table->string('bank')->nullable();
            $table->string('unit_cabang')->nullable();
            $table->string('no_rekening')->nullable();
            $table->bigInteger('mbs')->default(0);
            $table->bigInteger('luas_tanah_milik')->default(0);
            $table->bigInteger('luas_tanah_bukan_milik')->default(0);
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
        Schema::dropIfExists('kampus_details');
    }
}
