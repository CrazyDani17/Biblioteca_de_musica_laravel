<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Song;
use App\Artista;

class SongController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs = Song::all();
        return view('canciones',compact('songs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artistas = Artista::all();
        return view('agregar_cancion',compact('artistas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'artista_id' => 'required',
            'fecha_de_lanzamiento' => 'required',
        ]);
        $nueva_cancion = new Song();
        $nueva_cancion->nombre = $request->nombre;
        $nueva_cancion->artista_id = $request->artista_id;
        $nueva_cancion->fecha_de_lanzamiento = $request->fecha_de_lanzamiento;
        $nueva_cancion->save();
        return back()->with('mensaje', 'Canción Agregada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
