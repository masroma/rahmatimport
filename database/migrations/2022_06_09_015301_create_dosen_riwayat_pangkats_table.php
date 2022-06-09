<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenRiwayatPangkatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_riwayat_pangkats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dosen_id');
            $table->string('pangkat')->nullable();
            $table->string('sk_pangkat')->nullable();
            $table->date('tanggal_sk_pangkat')->nullable();
            $table->string('TMT_pangkat')->nullable();
            $table->string('masa_kerja')->nullable();
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
        Schema::dropIfExists('dosen_riwayat_pangkats');
    }
}
