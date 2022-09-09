<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNilaiPerkuliahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_perkuliahans', function (Blueprint $table) {
            $table->integer('semester_ke');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai_perkuliahans', function (Blueprint $table) {
            $table->dropColumn('semester_ke');
        });
    }
}
