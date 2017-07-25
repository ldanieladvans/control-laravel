<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Art69 extends Model
{
    protected $table = '69';

    protected $fillable = [
        'rfc', 'contribuyente', 'tipo', 'oficio', 'fecha_sat', 'fecha_dof', 'url_oficio', 'url_anexo'
    ];
}
