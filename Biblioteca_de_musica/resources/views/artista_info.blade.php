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
				<h1>{{$info->nombre}}</h1>
				<p>{{$info->descripcion}}</p>
				<p>Fecha de nacimiento: {{$info->fecha_de_nacimiento}}</p>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection