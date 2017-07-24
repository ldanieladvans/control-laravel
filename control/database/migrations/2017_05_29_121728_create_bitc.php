<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitc', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //Added
            $table->integer('bitc_usrc_id')->unsigned()->nullable();
            $table->timestampTz('bitc_fecha')->nullable();
            $table->string('bitc_tipo_op',25)->nullable();
            $table->string('bitc_ip',50)->nullable();
            $table->string('bitc_naveg',100)->nullable();
            $table->string('bitc_modulo',100)->nullable();
            $table->string('bitc_usrc_name',100)->nullable();
            $table->text('bitc_result')->nullable();
            $table->text('bitc_msj')->nullable();
            $table->text('bitc_dat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bitc');
    }
}
