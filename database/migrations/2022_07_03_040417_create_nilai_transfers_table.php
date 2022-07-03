<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('mahasiswa_id');
            $table->string('kode_perguruantinggi_asal')->nullable();
            $table->string('perguruantinggi_asal')->nullable();
            $table->string('kode_mk_asal');
            $table->string('matakuliah_asal');
            $table->string('sks_asal');
            $table->string('nilai_huruf_asal');
            $table->string('matakuliah_diakui');
            $table->decimal('nilai_index_diakui',5,2);
            $table->string('nilai_huruf_diakui');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_transfers');
    }
}
