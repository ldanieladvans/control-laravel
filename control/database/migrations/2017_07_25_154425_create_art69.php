<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArt69 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('69', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('rfc',13)->nullable();
            $table->string('contribuyente',500)->nullable();
            $table->string('tipo',100)->nullable();
            $table->string('oficio',100)->nullable();
            $table->datetime('fecha_sat')->nullable();
            $table->datetime('fecha_dof')->nullable();
            $table->string('url_oficio',100)->nullable();
            $table->string('url_anexo',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('69');
    }
}
