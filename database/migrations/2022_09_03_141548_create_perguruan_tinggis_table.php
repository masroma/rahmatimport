<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerguruanTinggisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perguruan_tinggis', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');
            $table->text('alamat');
            $table->integer('province_id');
            $table->integer('city_id');
            $table->bigInteger('district_id');
            $table->bigInteger('village_id');
            $table->bigInteger('kode_pos');
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
        Schema::dropIfExists('perguruan_tinggis');
    }
}
