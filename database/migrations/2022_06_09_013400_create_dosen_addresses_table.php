<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dosen_id');
            $table->string('jalan')->nullable();
            $table->integer('province_id');
            $table->integer('city_id');
            $table->integer('district_id');
            $table->integer('village_id');
            $table->string('kode_pos')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
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
        Schema::dropIfExists('dosen_addresses');
    }
}
