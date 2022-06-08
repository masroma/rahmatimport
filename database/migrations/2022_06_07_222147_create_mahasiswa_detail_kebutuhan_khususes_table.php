<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaDetailKebutuhanKhususesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_detail_kebutuhan_khususes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mahasiswa_id');
            $table->enum('kebutuhan_khusus',['y','n'])->default('n');
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
        Schema::dropIfExists('mahasiswa_detail_kebutuhan_khususes');
    }
}
