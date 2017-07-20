<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppcta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appcta', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //Added
            $table->string('appcta_app',15);
            $table->integer('appcta_cuenta_id')->unsigned()->nullable();
            $table->integer('appcta_paq_id')->unsigned()->nullable();
            $table->integer('appcta_distrib_id')->unsigned()->nullable();
            $table->float('appcta_gig')->nullable();
            $table->integer('appcta_rfc')->nullable();
            $table->date('appcta_f_vent')->nullable();
            $table->date('appcta_f_act')->nullable();
            $table->date('appcta_f_fin')->nullable();
            $table->date('appcta_f_caduc')->nullable();
            $table->boolean('appcta_activo')->default(1);
            $table->string('appcta_estado',20)->default('Inactiva');
            $table->string('sale_estado',20)->default('Prueba');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appcta');
    }
}
