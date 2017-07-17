<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
    protected $table = 'appsconf';

    protected $fillable = [
        'name', 'code', 'base_price','trial_days','app_activo'
    ];
}
