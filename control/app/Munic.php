<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Munic extends Model
{
    protected $table = 'munic';

    protected $fillable = [
        'm_code', 'm_state', 'm_description'
    ];
}
