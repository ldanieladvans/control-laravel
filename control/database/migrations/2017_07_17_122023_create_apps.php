<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appsconf', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name',100)->nullable();
            $table->string('code',5)->nullable();
            $table->double('base_price', 7, 2)->default(0);
            $table->integer('trial_days')->default(30);
            $table->boolean('app_activo')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appsconf');
    }
}
