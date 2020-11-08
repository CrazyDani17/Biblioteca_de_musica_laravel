@extends ('plantilla')

@if ( session('mensaje') )
    <div class="alert alert-success">
        {{ session('mensaje') }}
    </div>
@endif

@section ('seccion')
<h1>Actualizar Informacion del Usuario: {{$usuario->nombre}}</h1>
<form action="{{route('usuario.update', $usuario->id)}}" method="POST">
    @method('PUT')
    @csrf
    <input type="text" name="nombre" placeHolder="Nombre" class="form-control mb-2" value="{{$usuario->nombre}}" >
    <input type="text" name="pais" placeHolder="Pais" class="form-control mb-2" value="{{$usuario->pais}}">
    <input type="date" name="fecha_de_nacimiento" placeHolder="Fecha_de_nacimiento" class="form-control mb-2" value="{{$usuario->fecha_de_nacimiento}}">
    <button class="btn btn-primary btn-block" type="submit">Actualizar</button>
</form>
@endsection