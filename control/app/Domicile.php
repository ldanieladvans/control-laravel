<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domicile extends Model
{
    protected $table = 'dom';

    protected $fillable = [
        'dom_calle', 'dom_numext', 'dom_numint', 'dom_col', 'dom_ciudad', 'dom_munic', 'dom_estado', 'dom_pais'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

    public function distributors()
    {
        return $this->hasMany('App\Distributor','distrib_dom_id');
    }

    public function clients()
    {
        return $this->hasMany('App\Client','cliente_dom_id');
    }
}
