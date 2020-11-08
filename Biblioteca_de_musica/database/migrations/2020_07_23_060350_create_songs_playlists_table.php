<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsPlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs_playlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('song_id'); // Relación con songs
            $table->foreign('song_id')->references('id')->on('songs'); // clave foranea
            $table->unsignedBigInteger('playlist_id'); // Relación con playlists
            $table->foreign('playlist_id')->references('id')->on('playlists'); // clave foranea
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs_playlists');
    }
}
