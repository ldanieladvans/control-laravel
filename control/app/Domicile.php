<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domicile extends Model
{
    protected $table = 'dom';

    protected $fillable = [
        'dom_calle', 'dom_numext', 'dom_numint', 'dom_col', 'dom_ciudad', 'dom_munic', 'dom_estado', 'dom_pais'
    ];
}
