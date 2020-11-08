<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    public function usuario(){ //$playlist->usuario->nombre
        return $this->belongsTo('App\User','users'); //La playlist es de un usuario
    }
    
    public function song()
    {
        return $this->belongsToMany('App\Song','songs_playlists')->withPivot('song_id');
        //return $this->belongsToMany('App\Song','songs_playlists','song_id');
    }
}
