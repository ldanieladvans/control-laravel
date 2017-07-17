<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountTl extends Model
{
    protected $table = 'accounttl';

    protected $fillable = [
        'acctl_f_ini', 'acctl_f_fin', 'acctl_f_corte','acctl_f_pago','acctl_estado'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

    public function account()
    {
        return $this->belongsTo('App\Account','cta_id');
    }
}
