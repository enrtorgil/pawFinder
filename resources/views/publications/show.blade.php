@extends('layout')

@section('content')
    <div class="container mt-4">
        <h1>{{ $publication->name }}</h1>

        <div class="row mb-4">
            <div class="col-md-6">
                <img src="{{ Storage::url($publication->image) }}" class="img-fluid" alt="{{ $publication->name }}">
            </div>
            <div class="col-md-6">
                <ul class="list-group mb-2">
                    <li class="list-group-item"><strong>Autor:</strong> {{ $publication->user->username }}</li>
                    <li class="list-group-item"><strong>Tipo:</strong> {{ $publication->type }}</li>
                    <li class="list-group-item"><strong>Tipo de Animal:</strong> {{ $publication->type_animal }}</li>
                    <li class="list-group-item"><strong>Tamaño:</strong> {{ $publication->size }}</li>
                    <li class="list-group-item"><strong>Fecha:</strong> {{ $publication->date }}</li>
                    <li class="list-group-item"><strong>Descripción:</strong> {{ $publication->description }}</li>
                </ul>
                <div id="mi_mapa" style="width: 100%; height: 400px;"></div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let map = L.map('mi_mapa').setView([{{ $publication->latitude }}, {{ $publication->longitude }}], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);

                L.marker([{{ $publication->latitude }}, {{ $publication->longitude }}]).addTo(map);
            });
        </script>
    </div>
@endsection
