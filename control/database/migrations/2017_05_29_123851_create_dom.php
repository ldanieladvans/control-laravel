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
            $table->string('dom_calle',25);
            $table->string('dom_numext',10)->nullable();
            $table->string('dom_numint',10)->nullable();
            $table->string('dom_col',30)->nullable();
            $table->string('dom_ciudad',25)->nullable();
            $table->string('dom_munic',25)->nullable();
            $table->string('dom_estado',25)->nullable();
            $table->string('dom_pais',25)->nullable();
            $table->string('dom_cp',10)->nullable();
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
