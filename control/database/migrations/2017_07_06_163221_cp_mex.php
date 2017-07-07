<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CpMex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpmex', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //Added
            $table->string('d_codigo',10)->nullable();
            $table->string('d_asenta',100)->nullable();
            $table->string('d_tipo_asenta',50)->nullable();
            $table->string('D_mnpio',100)->nullable();
            $table->string('d_estado',50)->nullable();
            $table->string('d_ciudad',100)->nullable();
            $table->string('d_CP',10)->nullable();
            $table->string('c_estado',10)->nullable();

            $table->string('c_oficina',10)->nullable();
            $table->string('c_CP',20)->nullable();
            $table->string('c_tipo_asenta',10)->nullable();
            $table->string('c_mnpio',10)->nullable();
            $table->string('id_asenta_cpcons',10)->nullable();
            $table->string('d_zona',50)->nullable();
            $table->string('c_cve_ciudad',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpmex');
    }
}
