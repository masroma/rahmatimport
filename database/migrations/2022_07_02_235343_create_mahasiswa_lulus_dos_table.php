<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaLulusDosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_lulus_dos', function (Blueprint $table) {
            $table->id();
            $table->integer('mahasiswa_id');
            $table->integer('jeniskeluar_id');
            $table->date('tanggal_keluat');
            $table->integer('jenissemester_id');
            $table->date('tanggal_sk')->nullable();
            $table->string('nomor_sk')->nullable();
            $table->decimal('ipk',5,2)->default(0);
            $table->text('keterangan')->nullable();
            $table->string('no_ijazah')->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa_lulus_dos');
    }
}
