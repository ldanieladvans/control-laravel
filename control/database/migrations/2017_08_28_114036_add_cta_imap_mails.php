<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCtaImapMails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cta_imap_mails', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('cim_rfc_account',20)->nullable();
            $table->string('cim_rfc_client',20)->nullable();
            $table->string('cim_account_prefix',5)->nullable();
            $table->string('cim_mail',100)->nullable();
            $table->integer('cim_account_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cta_imap_mails');
    }
}
