<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrib extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distrib', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //Added
            $table->string('distrib_nom',80);
            $table->string('distrib_rfc',13);
            $table->time('distrib_f_nac')->nullable();
            $table->float('distrib_limitgig')->nullable();
            $table->integer('distrib_limitrfc')->nullable();
            $table->string('distrib_tel',20)->nullable();
            $table->string('distrib_correo',100)->nullable();
            $table->string('distrib_sector',30)->nullable();
            $table->string('distrib_nac',20)->nullable();
            $table->boolean('distrib_sup')->default(0);
            $table->timestampTz('distrib_f_creac')->nullable();
            $table->boolean('distrib_activo')->default(1);
            $table->integer('distrib_dom_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distrib');
    }
}
