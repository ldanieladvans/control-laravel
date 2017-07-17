<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccounttl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounttl', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('acctl_f_ini')->nullable();
            $table->date('acctl_f_fin')->nullable();
            $table->date('acctl_f_corte')->nullable();
            $table->date('acctl_f_pago')->nullable();
            $table->string('acctl_estado',15)->nullable();
            $table->integer('cta_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounttl');
    }
}
