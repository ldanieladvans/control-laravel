<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'paq';

    protected $fillable = [
        'paq_nom', 'paq_gig', 'paq_rfc'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

    //Many2many version commented because the extra data
    /*public function distributors()
    {
        return $this->belongsToMany('App\Distributor', 'asigpaq', 'asigpaq_paq_id', 'asigpaq_distrib_id');
    }*/

    public function distributors()
    {
        return $this->hasMany('App\Packageassignation','asigpaq_paq_id');
    }

    public function accounts()
    {
        return $this->hasMany('App\Account','appcta_paq_id');
    }
}
