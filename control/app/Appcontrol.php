<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appcontrol extends Model
{
    protected $table = 'app';

    protected $fillable = [
        'app_appcta_id', 'app_nom', 'app_code'
    ];

    public function __construct()
    {
        $this->connection = \Session::get('selected_database','mysql');
    }

    public function appcta()
    {
        return $this->belongsTo('App\Appaccount','app_appcta_id');
    }
}
