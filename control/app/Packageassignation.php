<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packageassignation extends Model
{
    protected $table = 'asigpaq';

    protected $fillable = [
        'asigpaq_distrib_id', 'asigpaq_paq_id', 'asigpaq_gig', 'asigpaq_rfc', 'asigpaq_f_vent', 'asigpaq_f_act', 'asigpaq_f_fin', 'asigpaq_f_caduc', 'asigpaq_activo'
    ];

    public function distributor()
    {
        return $this->belongsTo('App\Distributor','asigpaq_distrib_id');
    }

    public function package()
    {
        return $this->belongsTo('App\Package','asigpaq_paq_id');
    }
}
