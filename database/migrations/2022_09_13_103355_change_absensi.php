<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absensi_pertemuan_kelas', function($table) {
            $table->renameColumn('pertemuan_1', 'pertemuan');
            $table->integer('jenissemester_id')->after('mahasiswa_id');
            $table->dropColumn('pertemuan_2');
            $table->dropColumn('pertemuan_3');
            $table->dropColumn('pertemuan_4');
            $table->dropColumn('pertemuan_5');
            $table->dropColumn('pertemuan_6');
            $table->dropColumn('pertemuan_7');
            $table->dropColumn('pertemuan_8');
            $table->dropColumn('pertemuan_9');
            $table->dropColumn('pertemuan_10');
            $table->dropColumn('pertemuan_11');
            $table->dropColumn('pertemuan_12');
            $table->dropColumn('pertemuan_13');
            $table->dropColumn('pertemuan_14');
            $table->dropColumn('pertemuan_15');
            $table->dropColumn('pertemuan_16');
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
