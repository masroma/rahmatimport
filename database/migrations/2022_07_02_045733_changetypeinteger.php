<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Changetypeinteger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_perkuliahans', function (Blueprint $table) {
            $table->decimal('nilai_angka',5,2)->nullable()->change();

        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->decimal('bobot_mata_kuliah',5,2)->default(0)->change();
            $table->decimal('bobot_tatap_muka',5,2)->default(0)->change();
            $table->decimal('bobot_pratikum',5,2)->default(0)->change();
            $table->decimal('bobot_praktek_lapanagn',5,2)->default(0)->change();
            $table->decimal('bobot_simulasi',5,2)->default(0)->change();
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
