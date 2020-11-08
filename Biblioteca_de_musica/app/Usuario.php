<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public function playlist()
    {
        return $this->hasMany('App\Playlist');
    }
}
