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
            $table->string('email',100)->unique();
            $table->string('password',255)->nullable();
            $table->rememberToken();
            $table->timestamps();
            //Added
            $table->string('usrc_nick',100)->nullable();
            $table->string('usrc_tel',15)->nullable();
            $table->boolean('usrc_super')->default(0);
            $table->timestampTz('usrc_ult_acces')->nullable();
            $table->boolean('usrc_activo')->default(1);
            $table->integer('usrc_distrib_id')->unsigned()->nullable();
            $table->string('usrc_pic')->nullable();
            $table->boolean('usrc_admin')->default(0);
            $table->string('usrc_type',3)->default('app');
            $table->boolean('pass_changed')->default(0);
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
