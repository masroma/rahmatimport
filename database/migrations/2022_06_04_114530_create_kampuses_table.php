<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKampusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kampus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kampus')->nullable();
            $table->string('kode_kampus')->nullable();
            $table->string('cabang_kampus')->nullable();
            $table->string('telephone')->nullable();
            $table->string('faximile')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
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
        Schema::dropIfExists('kampuses');
    }
}
