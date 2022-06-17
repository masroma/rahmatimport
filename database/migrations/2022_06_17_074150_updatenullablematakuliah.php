<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Updatenullablematakuliah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->string('metode_pembelajaran')->nullable()->change();
            $table->date('tanggal_mulai_efektif')->nullable()->change();
            $table->date('tanggal_akhir_efektif')->nullable()->change();
            $table->integer('jenis_mata_kuliah')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
