<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCalculateIpsIpkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calculate_ips_ipk', function (Blueprint $table) {
            $table->integer('programstudy_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calculate_ips_ipk', function (Blueprint $table) {
            $table->dropColumn('programstudy_id');

        });
    }
}
