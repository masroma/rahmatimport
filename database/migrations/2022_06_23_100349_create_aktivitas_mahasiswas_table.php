<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktivitasMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivitas_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->integer("programstudy_id");
            $table->integer("semester_id");
            $table->string("no_sk_tugas");
            $table->date("tanggal_sk_tugas");
            $table->integer("jenisaktivitas_id");
            $table->enum("jenis_anggota",["personal","kelompok"]);
            $table->text("judul");
            $table->text("keterangan");
            $table->string("lokasi");
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
        Schema::dropIfExists('aktivitas_mahasiswas');
    }
}
