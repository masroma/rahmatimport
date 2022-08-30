<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJatahKrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jatah_krs', function (Blueprint $table) {
            $table->id();
            $table->decimal('ip_min',5,2);
            $table->decimal('ip_max',5,2);
            $table->integer('jumlah_sks');
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
        Schema::dropIfExists('jatah_krs');
    }
}
