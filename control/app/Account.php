<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'cta';

    protected $fillable = [
        'cta_cliente_id', 'cta_distrib_id', 'cta_nomservd', 'cta_num', 'cta_fecha', 'cta_nom_bd', 'cta_estado'
    ];

    public function distributor()
    {
        return $this->belongsTo('App\Distributor','cta_distrib_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Client','cta_cliente_id');
    }

    public function packages()
    {
        return $this->hasMany('App\Package','appcta_cuenta_id');
    }
}
