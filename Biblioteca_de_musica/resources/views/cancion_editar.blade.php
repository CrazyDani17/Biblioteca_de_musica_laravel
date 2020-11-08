@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Actualizar Informacion de la cancion: {{$cancion->nombre}}</span>
                    <a href="/artistas" class="btn btn-primary btn-sm">Volver a lista de Canciones</a>
                </div>
                <div class="card-body">  
                  @if ( session('mensaje') )
                    <div class="alert alert-success">{{ session('mensaje') }}</div>
                  @endif
					<form action="{{route('cancion.update', $cancion->id)}}" method="POST">
					    @method('PUT')
					    @csrf
                        @error('nombre')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              El nombre es requerido
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        @enderror @if ($errors->has('artista'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              El artista es requerido
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        @endif
                        @if ($errors->has('fecha_de_lanzamiento'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              La fecha de lanzamiento es requerida
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        @endif
					    <input type="text" name="nombre" placeHolder="Nombre" class="form-control mb-2" value="{{$cancion->nombre}}" >
					    <select class="form-control" name="artista_id">
                        <option selected>Selecciona un artista</option>
                        @foreach($artistas as $artista)
                            <option value="{{$artista->id}}">{{$artista->nombre}}</option>
                        @endforeach
                        </select>
					    <input type="date" name="fecha_de_lanzamiento" placeHolder="Fecha_de_lanzamiento" class="form-control mb-2" value="{{$cancion->fecha_de_lanzamiento}}" >
					    <button class="btn btn-primary btn-block" type="submit">Editar</button>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection