@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Actualizar Informacion del Artista: {{$artista->nombre}}</span>
                    <a href="/artistas" class="btn btn-primary btn-sm">Volver a lista de Artistas</a>
                </div>
                <div class="card-body">   
                  @if ( session('mensaje') )
                    <div class="alert alert-success">{{ session('mensaje') }}</div>
                  @endif
                  <form action="{{route('artista.update',$artista->id)}}" method="POST">
                        @method('PUT')
                        @csrf
                        @error('nombre')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              El nombre es requerido
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        @enderror @if ($errors->has('descripcion'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              La descripción es requerida
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        @endif
                        @if ($errors->has('nacionalidad'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              La nacionalidad es requerida
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        @endif
                        @if ($errors->has('fecha_de_nacimiento'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              La fecha de nacimiento es requerida
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        @endif
                        <input type="text" name="nombre" placeHolder="Nombre" class="form-control mb-2" value="{{$artista->nombre}}">
                        <input type="text" name="descripcion" placeHolder="Descripción" class="form-control mb-2" value="{{$artista->descripcion}}">
                        <input type="text" name="nacionalidad" placeHolder="Nacionalidad" class="form-control mb-2" value="{{$artista->nacionalidad}}">
                        <input type="date" name="fecha_de_nacimiento" placeHolder="Fecha_de_nacimiento" class="form-control mb-2" value="{{$artista->fecha_de_nacimiento}}">
                        <button class="btn btn-primary btn-block" type="submit">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection