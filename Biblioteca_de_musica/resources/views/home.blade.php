@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Bienvenido!') }}
                    {{ __('Aporta a nuestra comunidad con nuevas canciones') }}
                    <a href="/canciones" class="btn btn-primary btn-sm">Ir a canciones</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
