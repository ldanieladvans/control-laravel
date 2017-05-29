<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $table = 'distrib';

    protected $fillable = [
        'distrib_nom', 'distrib_rfc', 'distrib_f_nac', 'distrib_limitgig', 'distrib_limitrfc', 'distrib_tel', 'distrib_correo', 'distrib_sector', 'distrib_nac', 'distrib_sup', 'distrib_f_creac', 'distrib_activo', 'distrib_dom_id'
    ];

    public function users()
    {
        return $this->hasMany('App\User','usrc_distrib_id');
    }
}
