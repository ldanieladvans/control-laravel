<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //Added
            $table->integer('cliente_refer_id')->unsigned()->nullable();
            $table->string('cliente_nom',80);
            $table->string('cliente_sexo',15)->nullable();
            $table->time('cliente_f_nac')->nullable();
            $table->string('cliente_rfc',13);
            $table->string('cliente_tipo',15)->nullable();
            $table->string('cliente_tel',20)->nullable();
            $table->string('cliente_correo',25)->nullable();
            $table->string('cliente_nac',20)->nullable();
            $table->integer('cliente_sector')->nullable();
            $table->timestampTz('cliente_f_creac')->nullable();
            $table->integer('cliente_dom_id')->unsigned()->nullable();
            $table->boolean('cliente_activo')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}
