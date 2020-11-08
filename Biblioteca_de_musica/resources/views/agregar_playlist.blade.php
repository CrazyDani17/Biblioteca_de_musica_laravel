@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Agregar nueva Playlist</span>
                    <a href="/playlists" class="btn btn-primary btn-sm">Volver a lista de playlists</a>
                </div>
                <div class="card-body">   
                  @if ( session('mensaje') )
                    <div class="alert alert-success">{{ session('mensaje') }}</div>
                  @endif
                  <form method="POST" action="/playlists">
                    @csrf
                    @error('nombre')
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        El nombre es requerido
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @enderror
                    <input
                      type="string"
                      name="nombre"
                      placeholder="Nombre"
                      class="form-control mb-2"
                    />
                    <button class="btn btn-primary btn-block" type="submit">Agregar</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection