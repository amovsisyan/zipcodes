<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCode extends Model
{
    protected $table = 'post_codes';

    protected $fillable = [
        'post_code'
    ];

    public function country(){
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function places(){
        return $this->hasMany('App\Place', 'post_code_id', 'id');
    }
}
