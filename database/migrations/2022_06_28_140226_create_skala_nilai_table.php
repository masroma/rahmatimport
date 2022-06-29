<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkalaNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skala_nilais', function (Blueprint $table) {
            $table->id();
            $table->integer("programstudy_id");
            $table->string('nilai_huruf');
            $table->float('nilai_index');
            $table->float('bobot_min');
            $table->float('bobot_max');
            $table->date("tanggal_mulai");
            $table->date("tanggal_akhir");
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
        Schema::dropIfExists('skala_nilais');
    }
}
