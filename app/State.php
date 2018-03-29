<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    protected $fillable = [
        'name', 'abbr'
    ];

    public function country(){
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function places(){
        return $this->hasMany('App\Place', 'state_id', 'id');
    }
}
