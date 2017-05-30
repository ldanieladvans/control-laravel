<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'usrc_nick', 'uscr_tel', 'usrc_super', 'usrc_ult_acces', 'usrc_activo', 'usrc_distrib_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function distributor()
    {
        return $this->belongsTo('App\Distributor','usrc_distrib_id');
    }

    public function binnacles()
    {
        return $this->hasMany('App\Binnacle','bitc_usrc_id');
    }
}
