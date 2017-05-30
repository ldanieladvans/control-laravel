<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paq', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //Added
            $table->string('paq_nom',20);
            $table->float('paq_gig')->nullable();
            $table->integer('paq_rfc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paq');
    }
}
