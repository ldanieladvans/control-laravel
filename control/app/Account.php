<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'distrib';

    protected $fillable = [
        'cta_cliente_id', 'cta_distrib_id', 'cta_nomservd', 'cta_num', 'cta_fecha', 'cta_nom_bd', 'cta_estado'
    ];
}
