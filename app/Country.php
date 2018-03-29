<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'name', 'abbr'
    ];

    public function postCodes(){
        return $this->hasMany('App\PostCode', 'country_id', 'id');
    }

    public function states(){
        return $this->hasMany('App\State', 'country_id', 'id');
    }
}
