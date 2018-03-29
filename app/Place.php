<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'places';

    protected $fillable = [
        'name', 'long', 'lat', 'state_id'
    ];

    public function state(){
        return $this->belongsTo('App\State', 'state_id');
    }

    public function postCode(){
        return $this->belongsTo('App\PostCode', 'post_code_id');
    }
}
