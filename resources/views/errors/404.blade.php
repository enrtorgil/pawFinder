@extends('layout')

@section('title', '404')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="{{ url('img/404.png') }}" class="responsive-404-img mb-4" alt="Error 404">
                <h1 class="display-1">404</h1>
                <p class="lead">No se ha encontrado el contenido solicitado</p>
                <a href="{{ route('index') }}" class="btn btn-primary">Volver al inicio</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('css/404.css') }}" rel="stylesheet">
@endpush

@php
    $hideNavbar = true;
    $hideFooter = true;
@endphp
