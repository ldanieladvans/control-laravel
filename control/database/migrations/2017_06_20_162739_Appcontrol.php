<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Appcontrol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('app_appcta_id')->unsigned()->nullable();
            $table->string('app_nom',25)->nullable();
            $table->string('app_code',3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app', function (Blueprint $table) {
            //
        });
    }
}
