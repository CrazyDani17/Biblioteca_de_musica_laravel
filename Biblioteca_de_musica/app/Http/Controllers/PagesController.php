<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class PagesController extends Controller
{   

    public function inicio(){
        return view('welcome');
    }

    public function editar_usuario($id){
        $usuario = App\Usuario::findOrfail($id);
        return view('usuario_editar',compact('usuario'));
    }

    public function editar_playlist($id){
        $playlist = App\Playlist::findOrfail($id);
        return view('playlist_editar',compact('playlist'));
    }

    public function editar_cancion($id){
        $cancion = App\Song::findOrfail($id);
        $artistas = App\Artista::all();
        return view('cancion_editar',compact('cancion','artistas'));
    }

    public function editar_artista($id){
        $artista = App\Artista::findOrfail($id);
        return view('artista_editar',compact('artista'));
    }

    public function nueva_playlist(){
        return view('agregar_playlist');
    }

    public function nueva_cancion(){
        return view('agregar_cancion');
    }

    public function nuevo_usuario(){
        return view('agregar_usuario');
    }

    public function nuevo_artista(){
        return view('agregar_artista');
    }

    public function crear_playlist(Request $request){
        //return $request->all();

        $nueva_playlist = new App\Playlist;
        $nueva_playlist->nombre = $request->nombre;
        $nueva_playlist->usuario = $request->usuario;
        //return $nueva_playlist;
        $nueva_playlist->save();
        return back()->with('mensaje', 'Playlist Agregada');
    }

    public function crear_usuario(Request $request){
        //return $request->all();

        $nuevo_usuario = new App\Usuario;
        $nuevo_usuario->nombre = $request->nombre;
        $nuevo_usuario->pais = $request->pais;
        $nuevo_usuario->fecha_de_nacimiento = $request->fecha_de_nacimiento;
        $nuevo_usuario->save();
        return back()->with('mensaje', 'Usuario Agregado');
    }

    public function crear_artista(Request $request){
        //return $request->all();

        $nuevo_artista = new App\Artista;
        $nuevo_artista->nombre = $request->nombre;
        $nuevo_artista->descripcion = $request->descripcion;
        $nuevo_artista->nacionalidad = $request->nacionalidad;
        $nuevo_artista->fecha_de_nacimiento = $request->fecha_de_nacimiento;
        $nuevo_artista->save();
        return back()->with('mensaje', 'Artista Agregado');
    }

    public function crear_cancion(Request $request){
        //return $request->all();

        $nueva_cancion = new App\Song;
        $nueva_cancion->nombre = $request->nombre;
        $nueva_cancion->artista_id = $request->artista_id;
        $nueva_cancion->fecha_de_lanzamiento = $request->fecha_de_lanzamiento;
        $nueva_cancion->save();
        return back()->with('mensaje', 'Artista Agregado');
    }

    public function usuario_update(Request $request, $id){
        $usuario = App\Usuario::findOrfail($id);
        $usuario->nombre = $request->nombre;
        $usuario->pais = $request->pais;
        $usuario->fecha_de_nacimiento = $request->fecha_de_nacimiento;
        $usuario->save();
        return back()->with('mensaje', 'Usuario Actualizado');
    }

    public function playlist_update(Request $request, $id){
        $request->validate([
            'nombre' => 'required'
        ]);
        $playlist = App\Playlist::findOrfail($id);
        $playlist->nombre = $request->nombre;
        $playlist->usuario = auth()->user()->email;
        $playlist->save();
        return back()->with('mensaje', 'Playlist Actualizada');
    }

    public function cancion_update(Request $request, $id){
        $request->validate([
            'nombre' => 'required',
            'artista_id' => 'required',
            'fecha_de_lanzamiento' => 'required',
        ]);
        $cancion = App\Song::findOrfail($id);
        $cancion->nombre = $request->nombre;
        $cancion->artista_id = $request->artista_id;
        $cancion->fecha_de_lanzamiento = $request->fecha_de_lanzamiento;
        $cancion->save();
        return back()->with('mensaje', 'Canción Actualizada');
    }

    public function artista_update(Request $request, $id){
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'nacionalidad' => 'required',
            'fecha_de_nacimiento' => 'required',
        ]);
        $artista = App\Artista::findOrfail($id);
        $artista->nombre = $request->nombre;
        $artista->descripcion = $request->descripcion;
        $artista->nacionalidad = $request->nacionalidad;
        $artista->fecha_de_nacimiento = $request->fecha_de_nacimiento;
        $artista->save();
        return back()->with('mensaje', 'Artista Actualizado');
    }

    public function usuario_delete($id){

        $usuario = App\Usuario::findOrFail($id);
        $usuario->delete();
    
        return back()->with('mensaje', 'Usuario Eliminado');
    }

    public function playlist_delete($id){

        $playlist = App\Playlist::findOrFail($id);
        $playlist->delete();
    
        return back()->with('mensaje', 'Playlist Eliminada');
    }

    public function cancion_delete($id){

        $cancion = App\Song::findOrFail($id);
        $cancion->delete();
    
        return back()->with('mensaje', 'Cancion Eliminada');
    }

    public function artista_delete($id){

        $artista = App\Artista::findOrFail($id);
        $artista->delete();
    
        return back()->with('mensaje', 'Artista Eliminado');
    }

    public function playlists(){
        $playlists = App\Playlist::all();
        return view('playlists',compact('playlists'));
    }

    public function canciones(){
        $songs = App\Song::all();
        return view('canciones',compact('songs'));
    }

    public function artista_info($id_artista){
        $info = App\Artista::findOrfail($id_artista);

        return view('artista_info',compact('info'));
    }

    public function playlist_info($id_playlist){
        $info = App\Playlist::findOrfail($id_playlist);
        $songs = App\Song::all();
        return view('playlist_info',compact('info','songs'));
    }

    public function usuario_info($id_usuario){
        $info = App\Usuario::findOrfail($id_usuario);
        return view('usuario_info',compact('info'));
    }

    public function usuarios($nombre = null){
        $usuarios = App\Usuario::all();
        return view('usuarios',compact('usuarios','nombre'));
    }

    public function artistas(){
        $artistas = App\Artista::all();
        return view('artistas',compact('artistas'));
    }

    public function agregar_cancion_playlist(Request $request){
        $playlist = App\Playlist::findOrFail($request->playlist_id);
        $playlist->song()->attach([$request->cancion_id]);
        return back()->with('mensaje', 'Cancion agregada');
    }

    public function eliminar_cancion_playlist($id_c,$id_p){
        $playlist = App\Playlist::findOrFail($id_p);
        $playlist->song()->detach([$id_c]);
        return back()->with('mensaje', 'Cancion eliminada');
        //return $id_c.$id_p;
    }
}
