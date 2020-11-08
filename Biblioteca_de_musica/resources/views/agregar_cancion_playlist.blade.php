@extends('layouts.app')

@if ( session('mensaje') )
    <div class="alert alert-success">
        {{ session('mensaje') }}
    </div>
@endif

@section('content')
<h1>Agregar una cancion a la Playlist:{{$playlist->nombre}}</h1>
@endsection