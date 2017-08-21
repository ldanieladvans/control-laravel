<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    protected $table = 'cta';

    protected $fillable = [
        'cta_cliente_id', 'cta_distrib_id', 'cta_nomservd', 'cta_num', 'cta_fecha', 'cta_nom_bd', 'cta_estado', 'cta_periodicity', 'cta_recursive','cta_fecha_act','cta_type'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

    public function distributor()
    {
        return $this->belongsTo('App\Distributor','cta_distrib_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Client','cta_cliente_id');
    }

    public function packages()
    {
        return $this->hasMany('App\Appaccount','appcta_cuenta_id');
    }

    public function apps()
    {
        return $this->hasMany('App\Appcontrol','app_cta_id');
    }

    public function timelines()
    {
        return $this->hasMany('App\AccountTl','cta_id');
    }

    public function hasApp($app_code,$count=false)
    {
        if($count!=false){
            $perms = DB::table('app')->where([
                ['app_code', '=', $app_code],
                ['app_cta_id', '=', $this->id],
            ])->count();
        }else{
            $perms = DB::table('app')->where([
                ['app_code', '=', $app_code],
                ['app_cta_id', '=', $this->id],
            ])->get();
        }
        

        return $perms;
    }

}
