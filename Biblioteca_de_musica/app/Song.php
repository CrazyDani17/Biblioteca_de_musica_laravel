<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public function artista(){ //$song->artista->nombre
        return $this->belongsTo('App\Artista'); //La cancion es de un artista
    }

    public function playlist(){// Muchos a muchos
        return $this->belongsToMany('App\Playlist','songs_playlists')->withPivot('playlist_id');
    }
}
