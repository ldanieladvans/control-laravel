<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Binnacle extends Model
{
    protected $table = 'bitc';

    protected $fillable = [
        'bitc_usrc_id', 'bitc_fecha', 'bitc_tipo_op', 'bitc_ip', 'bitc_naveg', 'bitc_modulo', 'bitc_result', 'bitc_msj', 'bitc_dat'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','bitc_usrc_id');
    }

}
