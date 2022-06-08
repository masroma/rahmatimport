<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique()->nullable();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->enum('jenis_kelamin',['laki-laki','perempuan']);
            $table->string('ibu_kandung');
            $table->date('tanggal_lahir');
            $table->enum('agama',['islam','kristen','katolik','hindu','budha','konghucu']);
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
        Schema::dropIfExists('mahasiswas');
    }
}
