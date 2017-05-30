<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsigpaq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asigpaq', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //Added
            $table->integer('asigpaq_distrib_id')->unsigned()->nullable();
            $table->integer('asigpaq_paq_id')->unsigned()->nullable();
            $table->float('asigpaq_gig')->nullable();
            $table->integer('asigpaq_rfc')->nullable();
            $table->timestampTz('asigpaq_f_vent')->nullable();
            $table->timestampTz('asigpaq_f_act')->nullable();
            $table->timestampTz('asigpaq_f_fin')->nullable();
            $table->timestampTz('asigpaq_f_caduc')->nullable();
            $table->boolean('asigpaq_activo')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asigpaq');
    }
}
