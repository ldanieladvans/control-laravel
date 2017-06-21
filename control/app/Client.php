<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'cliente';

    protected $fillable = [
        'cliente_refer_id', 'cliente_nom', 'cliente_sexo', 'cliente_f_nac', 'cliente_rfc', 'cliente_tipo', 'cliente_tel', 'cliente_correo', 'cliente_nac', 'cliente_sector', 'cliente_f_creac', 'cliente_dom_id', 'cliente_activo'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

    public function distributor()
    {
        return $this->belongsTo('App\Domicile','cliente_dom_id');
    }

    public function accounts()
    {
        return $this->hasMany('App\Account','cta_cliente_id');
    }

    public function reference()
    {
        return $this->belongsTo('App\Reference','cliente_refer_id');
    }
}
