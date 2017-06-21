<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $table = 'refer';

    protected $fillable = [
        'refer_nom', 'refer_rfc'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

    public function clients()
    {
        return $this->hasMany('App\Client','cliente_refer_id');
    }
}
