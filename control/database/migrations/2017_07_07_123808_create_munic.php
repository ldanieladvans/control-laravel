<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('munic', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //Added
            $table->string('m_code',5)->nullable();
            $table->string('m_state',5)->nullable();
            $table->string('m_description',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('munic');
    }
}
