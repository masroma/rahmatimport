<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNeoFeederAdditionalDataToTableProgramStudies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_studies', function (Blueprint $table) {
            $table->string('neo_feeder_id')->nullable();
            $table->boolean('is_neo_feeder_already_sync')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_studies', function (Blueprint $table) {
            //
        });
    }
}
