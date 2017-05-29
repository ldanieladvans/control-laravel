<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'paq';

    protected $fillable = [
        'paq_nom', 'paq_gig', 'paq_rfc'
    ];
}
