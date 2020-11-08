@extends('plantilla')

@if ( session('mensaje') )
    <div class="alert alert-success">
        {{ session('mensaje') }}
    </div>
@endif

@section('seccion')
    <h1 class="display-4">Usuarios</h1>
    <a href="{{ route('agregar_usuario') }}" class="btn btn-primary">Agregar un nuevo usuario</a><br>
    <table class="table">
    <thead>
        <tr>
        <th scope="col">#id</th>
        <th scope="col">Nombre</th>
        <th scope="col">Pais</th>
        <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
        <tr>
        <th scope="row">{{$usuario->id}}</th>
        <td>
            <a href="{{route('usuario',$usuario)}}">
                {{$usuario->nombre}}
            </a>
        </td>
        <td>{{$usuario->pais}}</td>
        <td>
            <a href="{{route('usuario.editar',$usuario)}}" class="btn btn-warning btn-sm">Editar</a>
            <form action="{{ route('usuario.eliminar', $usuario) }}" class="d-inline" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
            </form>
        </td>
        </tr>
        @endforeach
    </tbody>
    </table>
@endsection