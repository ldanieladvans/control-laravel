<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dom', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //Added
            $table->string('dom_calle',255)->nullable();
            $table->string('dom_numext',255)->nullable();
            $table->string('dom_numint',255)->nullable();
            $table->string('dom_col',255)->nullable();
            $table->string('dom_ciudad',255)->nullable();
            $table->string('dom_munic',255)->nullable();
            $table->string('dom_estado',255)->nullable();
            $table->string('dom_pais',255)->nullable();
            $table->string('dom_cp',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dom');
    }
}
