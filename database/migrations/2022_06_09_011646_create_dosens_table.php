<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dosen');
            $table->string('nidn')->unique();
            $table->enum('jenis_kelamin',['laki-laki','perempuan']);
            $table->enum('agama',['islam','kristen','katolik','hindu','budha','konghucu']);
            $table->date('tanggal_lahir');
            $table->date('tempat_lahir');
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
        Schema::dropIfExists('dosens');
    }
}
