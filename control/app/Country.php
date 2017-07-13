<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'c_char_min_code', 'c_char_code', 'c_code', 'c_name_es', 'c_name_en'
    ];
}
