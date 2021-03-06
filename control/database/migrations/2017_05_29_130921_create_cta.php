<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cta', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //Added
            $table->integer('cta_cliente_id')->unsigned()->nullable();
            $table->integer('cta_distrib_id')->unsigned()->nullable();
            $table->string('cta_nomservd',20)->nullable();
            $table->string('cta_num',25)->nullable();
            $table->date('cta_fecha')->nullable();
            $table->date('cta_fecha_act')->nullable();
            $table->string('cta_nom_bd',25)->nullable();
            $table->string('cta_estado',20)->nullable();
            $table->string('cta_periodicity',20)->nullable();
            $table->boolean('cta_recursive')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cta');
    }
}
