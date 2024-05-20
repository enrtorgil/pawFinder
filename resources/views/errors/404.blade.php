@extends('layout')

@section('title', '404')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-1">404</h1>
                <p class="lead">Error 404: No se ha encontrado el contenido solicitado.</p>
                <a href="{{ route('index') }}" class="btn btn-primary">Volver al inicio</a>
            </div>
        </div>
    </div>
@endsection

@php
    $hideNavbar = true;
    $hideFooter = true;
@endphp
