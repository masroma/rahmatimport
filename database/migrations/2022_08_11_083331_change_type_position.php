<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypePosition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        // Schema::table('menus', function (Blueprint $table) {
        //     $table->enum('position',['none','single','parent','children'])->change();
        // });

        \DB::statement("ALTER TABLE `menus` CHANGE `position` `position` ENUM('none','single','parent', 'children') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none';");
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
