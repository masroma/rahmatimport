<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Addkolomruangperkuliahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelas_perkuliahans', function (Blueprint $table) {
            $table->integer('min_peserta')->after('kode')->nullable();
            $table->integer('max_peserta')->after('min_peserta')->nullable();
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->decimal('min_nilai_kelulusan',5,2)->after('bobot_simulasi')->default(0);
        });

        Schema::create('persyaratan_kelas_perkuliahan', function (Blueprint $table) {
            $table->id();
            $table->integer('kelasperkuliahan_id');
            $table->text('key')->nullable();
            $table->text('value')->nullable();
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
        //
    }
}
