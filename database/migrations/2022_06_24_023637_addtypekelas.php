<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Addtypekelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ruang_perkuliahans', function (Blueprint $table) {
            $table->integer('penggunaanruang_id')->after('kelasperkuliahan_id')->nullable();
            $table->text('waktu')->after('hari')->nullable();
            $table->dropColumn('jam_mulai');
            $table->dropColumn('jam_akhir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
