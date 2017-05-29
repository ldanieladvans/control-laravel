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
            $table->float('appcta_gig');
            $table->integer('appcta_rfc');
            $table->timestampTz('appcta_f_vent')->nullable();
            $table->timestampTz('appcta_f_act')->nullable();
            $table->timestampTz('appcta_f_fin')->nullable();
            $table->timestampTz('appcta_f_caduc')->nullable();
            $table->boolean('appcta_activo');
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
