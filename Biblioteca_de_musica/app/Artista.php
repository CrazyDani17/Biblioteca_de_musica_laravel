<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    public function song()
    {
        return $this->hasMany('App\Song');
    }
}
