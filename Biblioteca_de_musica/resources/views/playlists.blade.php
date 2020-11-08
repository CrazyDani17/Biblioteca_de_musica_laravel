@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="display-4">Playlists</h1>
      <a href="/playlists/create" class="btn btn-primary">Agregar una nueva playlist</a>
      <div class="card-body">
        @if ( session('mensaje') )
          <div class="alert alert-success">{{ session('mensaje') }}</div>
        @endif
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#id</th>
              <th scope="col">Nombre</th>
              <th scope="col">Usuario</th>
              <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($playlists as $playlist)
            <tr>
              <th scope="row">{{$playlist->id}}</th>
              <td>
                <a href="{{route('playlist',$playlist)}}">
                    {{$playlist->nombre}}
                </a>
              </td>
              <td>
                <a href="{{route('usuario',$playlist->usuario)}}">
                    {{auth()->user()->name}}
                </a>
              </td>
              <td>
                <a href="{{route('playlist.editar',$playlist)}}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('playlist.eliminar', $playlist) }}" class="d-inline" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{$playlists->links()}}
      </div>
    </div>
  </div>
</div>
@endsection