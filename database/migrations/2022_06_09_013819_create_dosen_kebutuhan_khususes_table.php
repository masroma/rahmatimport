<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenKebutuhanKhususesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_kebutuhan_khususes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dosen_id');
            $table->text('jenis_kebutuhan_khusus')->nullable();
            $table->enum('handle_kebutuhan_khusus',['y','n'])->nullable();
            $table->enum('handle_bahasa_isyarat',['y','n'])->nullable();
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen_kebutuhan_khususes');
    }
}
