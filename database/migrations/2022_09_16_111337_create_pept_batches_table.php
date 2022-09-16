<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeptBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pept_batches', function (Blueprint $table) {
            $table->id();
            $table->integer('jenissemester_id');
            $table->string("nama_batch");
            $table->integer("grade_pept");
            $table->integer("grade_sidang");
            $table->date("tanggal_pendaftaran");
            $table->date("tanggal_tutup_pendaftaran");
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
        Schema::dropIfExists('pept_batches');
    }
}
