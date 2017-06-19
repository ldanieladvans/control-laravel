<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appaccount extends Model
{
    protected $table = 'appcta';

    protected $fillable = [
        'appcta_app', 'appcta_cuenta_id', 'appcta_paq_id', 'appcta_gig', 'appcta_rfc', 'appcta_f_vent', 'appcta_f_act', 'appcta_f_fin', 'appcta_f_caduc', 'appcta_activo'
    ];

    public function __construct()
    {
        $this->connection = \Session::get('selected_database','mysql');
    }

    public function account()
    {
        return $this->belongsTo('App\Account','appcta_cuenta_id');
    }

    public function package()
    {
        return $this->belongsTo('App\Package','appcta_paq_id');
    }
}
