<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Appaccount extends Model
{
    protected $table = 'appcta';

    protected $fillable = [
        'app_nom', 'appcta_cuenta_id', 'appcta_paq_id', 'appcta_gig', 'appcta_rfc', 'appcta_f_vent', 'appcta_f_act', 'appcta_f_fin', 'appcta_f_caduc', 'appcta_activo', 'appcta_estado', 'sale_estado','appcta_distrib_id'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

    public function account()
    {
        return $this->belongsTo('App\Account','appcta_cuenta_id');
    }

    public function package()
    {
        return $this->belongsTo('App\Package','appcta_paq_id');
    }

    public function distributor()
    {
        return $this->belongsTo('App\Distributor','appcta_distrib_id');
    }

    public function apps()
    {
        return $this->hasMany('App\Appcontrol','app_appcta_id');
    }


    public function hasApp($app_code,$count=false)
    {

        if($count!=false){
            $perms = DB::table('app')->where([
                ['app_code', '=', $app_code],
                ['app_appcta_id', '=', $this->id],
            ])->count();
        }else{
            $perms = DB::table('app')->where([
                ['app_code', '=', $app_code],
                ['app_appcta_id', '=', $this->id],
            ])->get();
        }
        

        return $perms;
    }
}
