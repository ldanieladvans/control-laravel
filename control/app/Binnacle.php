<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Binnacle extends Model
{
    protected $table = 'bitc';

    protected $fillable = [
        'bitc_usrc_id', 'bitc_fecha', 'bitc_tipo_op', 'bitc_ip', 'bitc_naveg', 'bitc_modulo', 'bitc_result', 'bitc_msj', 'bitc_dat'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

    public function user()
    {
        return $this->belongsTo('App\User','bitc_usrc_id');
    }

}
