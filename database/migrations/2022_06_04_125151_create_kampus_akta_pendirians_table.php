<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKampusAktaPendiriansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kampus_akta_pendirians', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kampus_id');
            $table->string('no_sk_pendirian')->nullable();
            $table->date('tanggal_sk_pendirian')->nullable();
            $table->string('status_kepemilikan')->nullable();
            $table->string('status_perguruan_tinggi')->nullable();
            $table->string('sk_izin_operasional')->nullable();
            $table->date('tanggal_izin_operasional')->nullable();
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
        Schema::dropIfExists('kampus_akta_pendirians');
    }
}
