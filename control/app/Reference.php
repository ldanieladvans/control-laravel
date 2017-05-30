<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $table = 'refer';

    protected $fillable = [
        'refer_nom', 'refer_rfc'
    ];

    public function clients()
    {
        return $this->hasMany('App\Client','cliente_refer_id');
    }
}
