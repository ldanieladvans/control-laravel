<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appcontrol extends Model
{
    protected $table = 'app';

    protected $fillable = [
        'app_appcta_id', 'app_nom', 'app_code'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

    public function appcta()
    {
        return $this->belongsTo('App\Appaccount','app_appcta_id');
    }

    public function cta()
    {
        return $this->belongsTo('App\Account','app_cta_id');
    }
}
