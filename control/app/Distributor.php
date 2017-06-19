<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $table = 'distrib';

    protected $fillable = [
        'distrib_nom', 'distrib_rfc', 'distrib_f_nac', 'distrib_limitgig', 'distrib_limitrfc', 'distrib_tel', 'distrib_correo', 'distrib_sector', 'distrib_nac', 'distrib_sup', 'distrib_f_creac', 'distrib_activo', 'distrib_dom_id'
    ];

    public function __construct()
    {
        $this->connection = \Session::get('selected_database','mysql');
    }

    public function users()
    {
        return $this->hasMany('App\User','usrc_distrib_id');
    }

    //Many2many version commented because the extra data
    /*public function packages()
    {
        return $this->belongsToMany('App\Package', 'asigpaq', 'asigpaq_distrib_id', 'asigpaq_paq_id');
    }*/

    public function packages()
    {
        return $this->hasMany('App\Packageassignation','asigpaq_distrib_id');
    }

    public function accounts()
    {
        return $this->hasMany('App\Account','cta_distrib_id');
    }

    public function domicile()
    {
        return $this->belongsTo('App\Domicile','distrib_dom_id');
    }
}
