<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('tittle',100)->nullable();
            $table->text('description')->nullable();
            $table->date('pdate')->nullable();
            $table->string('nlink',255)->nullable();
            $table->boolean('nactivo')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            //
        });
    }
}
