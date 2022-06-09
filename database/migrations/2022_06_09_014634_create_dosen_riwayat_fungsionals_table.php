<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenRiwayatFungsionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_riwayat_fungsionals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dosen_id');
            $table->string('jabatan')->nullable();
            $table->string('sk_jabatan')->nullable();
            $table->string('TMT_jabatan')->nullable();
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
        Schema::dropIfExists('dosen_riwayat_fungsionals');
    }
}
