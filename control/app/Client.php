<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'cliente';

    protected $fillable = [
        'cliente_refer_id', 'cliente_nom', 'cliente_sexo', 'cliente_f_nac', 'cliente_rfc', 'cliente_tipo', 'cliente_tel', 'cliente_correo', 'cliente_nac', 'cliente_sector', 'cliente_f_creac', 'cliente_dom_id', 'cliente_activo'
    ];
}
