@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{$info->nombre}}</span>
                    <a href="/artistas" class="btn btn-primary btn-sm">Volver a lista de Artistas</a>
                </div>
                <div class="card-body">
                  <p>Usuario: {{auth()->user()->name}}</p>
                  <form class="form-inline" action="{{route('cancion_playlist.agregar')}}" method="POST">
                      @csrf
                      <div class="form-group">
                          <label for="staticText"  class="col-sm-2 col-form-label">Id playlist</label>
                          <div class="col-sm-10">
                              <input type="text" name="playlist_id" readonly class="form-control-plaintext" id="staticText" value="{{$info->id}}">
                          </div>
                      </div>
                      <div class="form-group mx-sm-3 mb-2">
                          <select class="form-control form-control-sm" name="cancion_id">
                              <option selected>Selecciona una cancion existente...</option>
                              @foreach($songs as $song)
                                  <option value="{{$song->id}}">{{$song->nombre}}</option>
                              @endforeach
                          </select>
                      </div>
                      <button class="btn btn-primary btn-block" type="submit">Agregar una cancion a la playlist</button>
                  </form>


                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Artista</th>
                        <th scope="col">Fecha de lanzamiento</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($info->song as $song)
                      <tr>
                        <th scope="row">{{$song->id}}</th>
                        <td>{{$song->nombre}}</td>
                        <td>
                          <a href="{{route('song.artista',$song->artista)}}">
                              {{$song->artista->nombre}}
                          </a>
                        </td>
                        <td>{{$song->fecha_de_lanzamiento}}</td>
                        <td>
                          <form action="{{ route('cancion_playlist.eliminar', [$song,$info->id]) }}" class="d-inline" method="POST">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection