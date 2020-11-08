@extends ('plantilla')

@if ( session('mensaje') )
    <div class="alert alert-success">
        {{ session('mensaje') }}
    </div>
@endif

@section ('seccion')
<h1>Agregar Nuevo Usuario</h1>
<form action="{{route('usuario.crear')}}" method="POST">
    @csrf
    <input type="text" name="nombre" placeHolder="Nombre" class="form-control mb-2">
    <input type="text" name="pais" placeHolder="Pais" class="form-control mb-2">
    <input type="date" name="fecha_de_nacimiento" placeHolder="Fecha_de_nacimiento" class="form-control mb-2">
    <button class="btn btn-primary btn-block" type="submit">Agregar</button>
</form>
@endsection