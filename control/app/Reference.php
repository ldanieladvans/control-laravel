<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $table = 'refer';

    protected $fillable = [
        'refer_nom', 'refer_rfc'
    ];
}
