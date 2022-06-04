<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKampusAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kampus_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kampus_id');
            $table->string('jalan')->nullable();
            $table->integer('province_id');
            $table->integer('city_id');
            $table->integer('district_id');
            $table->integer('village_id');
            $table->string('kode_pos')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('google_map')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
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
        Schema::dropIfExists('kampus_addresses');
    }
}
