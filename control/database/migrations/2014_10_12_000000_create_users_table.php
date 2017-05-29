<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('email',25)->unique();
            $table->string('password',25);
            $table->rememberToken();
            $table->timestamps();
            //Added
            $table->string('usrc_nick',10);
            $table->string('usrc_tel',15);
            $table->boolean('usrc_super');
            $table->timestampTz('usrc_ult_acces')->nullable();
            $table->boolean('usrc_activo');
            $table->integer('usrc_distrib_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
