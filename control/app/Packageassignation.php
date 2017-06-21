<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packageassignation extends Model
{
    protected $table = 'asigpaq';

    protected $fillable = [
        'asigpaq_distrib_id', 'asigpaq_paq_id', 'asigpaq_gig', 'asigpaq_rfc', 'asigpaq_f_vent', 'asigpaq_f_act', 'asigpaq_f_fin', 'asigpaq_f_caduc', 'asigpaq_activo'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

    public function distributor()
    {
        return $this->belongsTo('App\Distributor','asigpaq_distrib_id');
    }

    public function package()
    {
        return $this->belongsTo('App\Package','asigpaq_paq_id');
    }
}
