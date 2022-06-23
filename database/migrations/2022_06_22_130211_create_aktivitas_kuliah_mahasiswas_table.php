<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktivitasKuliahMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivitas_kuliah_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->integer("mahasiswa_id");
            $table->integer('semester_id');
            $table->integer('status_id');
            $table->decimal('ips');
            $table->decimal('ipk');
            $table->integer('jumlah_sks_semester');
            $table->integer('sks_total');
            $table->integer('biaya_kuliah');
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
        Schema::dropIfExists('aktivitas_kuliah_mahasiswas');
    }
}
