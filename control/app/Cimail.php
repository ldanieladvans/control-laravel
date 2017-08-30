<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cimail extends Model
{
    protected $table = 'cta_imap_mails';

    protected $fillable = [
        'cim_rfc_account', 'cim_rfc_client', 'cim_account_prefix', 'cim_mail', 'cim_account_id'
    ];

    public function account()
    {
        return $this->belongsTo('App\Account','cim_account_id');
    }
}
