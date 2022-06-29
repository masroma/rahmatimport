<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaturanPeriodePerkuliahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_periode_perkuliahans', function (Blueprint $table) {
            $table->id();
            $table->integer("programstudy_id");
            $table->integer("semester_id");
            $table->integer("target_mahasiswa_baru");
            $table->integer("pendaftar_ikut_seleksi");
            $table->integer("pendaftar_lulus_seleksi");
            $table->integer("pendaftar_daftar_ulang");
            $table->integer("pendaftar_mengundurkan_diri");
            $table->integer("jumlah_pertemuan");
            $table->date("awal_perkuliahan");
            $table->date("akhir_perkuliahan");
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
        Schema::dropIfExists('pengaturan_periode_perkuliahans');
    }
}
