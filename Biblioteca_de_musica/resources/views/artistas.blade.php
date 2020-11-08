@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="display-4">Artistas</h1>
      <a href="/artistas/create"class="btn btn-primary">Agregar una nuevo artista</a>
      <div class="card-body">
        @if ( session('mensaje') )
          <div class="alert alert-success">{{ session('mensaje') }}</div>
        @endif
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#id</th>
              <th scope="col">Nombre</th>
              <th scope="col">Nacionalidad</th>
              <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($artistas as $artista)
            <tr>
              <th scope="row">{{$artista->id}}</th>
              <td>
                <a href="{{route('song.artista',$artista)}}">
                    {{$artista->nombre}}
                </a>
              </td>
              <td>{{$artista->nacionalidad}}</td>
              <td>
                <a href="{{route('artista.editar',$artista)}}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('artista.eliminar', $artista) }}" class="d-inline" method="POST">
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
@endsection