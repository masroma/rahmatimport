<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenRiwayatPenelitiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_riwayat_penelitians', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dosen_id');
            $table->string('judul_penelitian')->nullable();
            $table->string('bidang_ilmu')->nullable();
            $table->string('lembaga')->nullable();
            $table->string('tahun')->nullable();
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
        Schema::dropIfExists('dosen_riwayat_penelitians');
    }
}
