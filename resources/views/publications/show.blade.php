@extends('layout')

@section('title', $publication->name)

@section('content')
    <div class="container mt-4">
        <h1>{{ $publication->name }}</h1>

        <div class="row mb-4">
            <div class="col-md-6">
                <img src="{{ Storage::url($publication->image) }}" class="img-fluid img-custom" alt="{{ $publication->name }}">
                <div class="d-flex justify-content-between mt-2">
                    <a href="{{ route('texts.create', ['publication_id' => $publication->id]) }}"
                        class="btn btn-success flex-grow-1 m-1"><i class='bx bx-envelope'></i></a>
                    @php
                        $isFavorited = Auth::user()->favs->contains($publication->id);
                    @endphp

                    <form
                        action="{{ $isFavorited ? route('publications.unfavorite', $publication->id) : route('publications.favorite', $publication->id) }}"
                        method="POST" class="d-inline flex-grow-1 m-1">
                        @csrf
                        @if ($isFavorited)
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100"><i class='bx bxs-heart'></i></button>
                        @else
                            <button type="submit" class="btn btn-warning w-100"><i class='bx bx-heart'></i></button>
                        @endif
                    </form>
                    <button type="button" class="btn btn-danger flex-grow-1 m-1" data-bs-toggle="modal"
                        data-id="{{ $publication->id }}" data-bs-target="#reportModal"><i class='bx bx-flag'></i></button>
                    <a href="{{ route('publications.index') }}" class="btn btn-secondary flex-grow-1 m-1"><i
                            class='bx bx-arrow-back'></i></a>
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column">
                <div class="flex-grow-1 mb-2">
                    <div class="card">
                        <div class="card-body border rounded p-3">
                            <h5 class="card-title text-primary border-bottom pb-2 mb-3">Detalles de la Publicación
                            </h5>
                            <p class="card-text mb-2"><strong>Autor:</strong> {{ $publication->user->username }}</p>
                            <p class="card-text mb-2"><strong>Tipo:</strong> {{ $publication->type }}</p>
                            <p class="card-text mb-2"><strong>Tipo de Animal:</strong> {{ $publication->type_animal }}</p>
                            <p class="card-text mb-2"><strong>Tamaño:</strong> {{ $publication->size }}</p>
                            <p class="card-text mb-2"><strong>Fecha:</strong>
                                {{ \Carbon\Carbon::parse($publication->date)->format('d-m-Y') }}</p>
                            <p class="card-text"><strong>Descripción:</strong>
                                <span
                                    class="text-muted">{{ \Illuminate\Support\Str::limit($publication->description, 40) }}</span>
                                @if (strlen($publication->description) > 40)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#descriptionModal">Leer más</a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1 mt-2" id="mi_mapa" style="width: 100%; height: 100%;"></div>
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

    <!-- Modal para la descripción -->
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descriptionModalLabel">Descripción completa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ $publication->description }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para reportar -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Reportar Publicación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm" method="POST" action="{{ route('publications.report', $publication->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="reason" class="form-label">Razón del Reporte</label>
                            <select class="form-select" id="reason" name="reason" required>
                                <option value="Contenido inapropiado">Contenido inapropiado</option>
                                <option value="Información incorrecta">Información incorrecta</option>
                                <option value="Spam">Spam</option>
                                <option value="Otra razón">Otra razón</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="additional_info" class="form-label">Información Adicional</label>
                            <textarea class="form-control" id="additional_info" name="additional_info" rows="3" maxlength="200"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Enviar Reporte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .img-custom {
            width: 100%;
            height: auto;
            min-height: 70vh;
            object-fit: cover;
        }

        .btn {
            padding: 0.5rem;
            margin: 0;
        }

        .modal-body {
            word-wrap: break-word;
        }
    </style>
@endsection
