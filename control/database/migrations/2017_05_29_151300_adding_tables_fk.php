<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingTablesFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->foreign('usrc_distrib_id')->references('id')->on('distrib');
        });

        Schema::table('bitc', function($table) {
            $table->foreign('bitc_usrc_id')->references('id')->on('users');
        });

        Schema::table('distrib', function($table) {
            $table->foreign('distrib_dom_id')->references('id')->on('dom');
        });

        Schema::table('asigpaq', function($table) {
            $table->foreign('asigpaq_paq_id')->references('id')->on('paq');
            $table->foreign('asigpaq_distrib_id')->references('id')->on('distrib');
        });

        Schema::table('cliente', function($table) {
            $table->foreign('cliente_dom_id')->references('id')->on('dom');
            $table->foreign('cliente_refer_id')->references('id')->on('refer');
        });

        Schema::table('cta', function($table) {
            $table->foreign('cta_distrib_id')->references('id')->on('distrib');
            $table->foreign('cta_cliente_id')->references('id')->on('cliente');
        });

        Schema::table('appcta', function($table) {
            $table->foreign('appcta_cuenta_id')->references('id')->on('cta');
            $table->foreign('appcta_paq_id')->references('id')->on('paq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
