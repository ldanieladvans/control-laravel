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
            $table->string('bitc_tipo_op',25);
            $table->string('bitc_ip',20);
            $table->string('bitc_naveg',20);
            $table->string('bitc_modulo',30);
            $table->text('bitc_result');
            $table->text('bitc_msj');
            $table->text('bitc_dat');
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
