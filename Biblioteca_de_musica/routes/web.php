<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*---------------------------Inicio-------------------------------*/

Route::get('/','PagesController@inicio');

/*---------------------------------Playlists---------------------------------------------*/

Route::resource('/playlists', 'PlaylistController');

Route::get('playlists/info/{playlist}','PagesController@playlist_info')->name('playlist');

//Route::get('playlists','PagesController@playlists')->name('playlists');

Route::get('playlists/nueva_playlist','PagesController@nueva_playlist')->name('agregar_playlist');

Route::post('nuevaplaylist','PagesController@crear_playlist')->name('playlist.crear');

Route::get('playlists/editar_playlist/{id}','PagesController@editar_playlist')->name('playlist.editar');

Route::put('playlists/editar_playlist/{id}','PagesController@playlist_update')->name('playlist.update');

Route::delete('playlists/eliminar_playlist/{id}','PagesController@playlist_delete')->name('playlist.eliminar');

/*-----------------------------------Canciones-----------------------------------------------------*/

Route::resource('/canciones', 'SongController');

Route::get('canciones', 'PagesController@canciones')->name('canciones');

Route::get('canciones/nueva_cancion','PagesController@nueva_cancion')->name('agregar_cancion');

Route::post('nuevacancion','PagesController@crear_cancion')->name('cancion.crear');

Route::get('canciones/editar_cancion/{id}','PagesController@editar_cancion')->name('cancion.editar');

Route::put('canciones/editar_cancion/{id}','PagesController@cancion_update')->name('cancion.update');

Route::delete('canciones/eliminar_cancion/{id}','PagesController@cancion_delete')->name('cancion.eliminar');

/*------------------------------------Usuarios-------------------------------------------------*/

Route::get('usuarios','PagesController@usuarios')->name('usuarios');

Route::get('usuarios/info/{nombre?}','PagesController@usuario_info')->name('usuario');

Route::get('usuarios/nuevo_usuario','PagesController@nuevo_usuario')->name('agregar_usuario');

Route::post('nuevousuario','PagesController@crear_usuario')->name('usuario.crear');

Route::get('usuarios/editar_usuario/{id}','PagesController@editar_usuario')->name('usuario.editar');

Route::put('usuarios/editar_usuario/{id}','PagesController@usuario_update')->name('usuario.update');

Route::delete('usuarios/eliminar_usuario/{id}','PagesController@usuario_delete')->name('usuario.eliminar');


/*-----------------------------artistas---------------------------------------*/

Route::resource('/artistas', 'ArtistaController');

Route::get('artistas', 'PagesController@artistas')->name('artistas');

Route::get('artistas/info/{artista}','PagesController@artista_info')->name('song.artista');

Route::get('artistas/nuevo_artista','PagesController@nuevo_artista')->name('agregar_artista');

Route::post('nuevoartista','PagesController@crear_artista')->name('artista.crear');

Route::get('artistas/editar_artista/{id}','PagesController@editar_artista')->name('artista.editar');

Route::put('artistas/editar_artista/{id}','PagesController@artista_update')->name('artista.update');

Route::delete('artistas/eliminar_artista/{id}','PagesController@artista_delete')->name('artista.eliminar');

/*-----------------------------Cancion-Playlist----------------------------------*/

Route::post('playlists/agregar_cancion','PagesController@agregar_cancion_playlist')->name('cancion_playlist.agregar');

Route::delete('playlists/eliminar_cancion/{id_c}/{id_p}','PagesController@eliminar_cancion_playlist')->name('cancion_playlist.eliminar');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
