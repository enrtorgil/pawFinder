@extends('layout')

@section('content')
    <div class="container mt-4">
        <h1>Mis Anuncios</h1>

        @if ($publications->isEmpty())
            <p>No has publicado ningún anuncio.</p>
        @else
            <div class="row">
                @foreach ($publications as $publication)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ Storage::url($publication->image) }}" class="card-img-top"
                                alt="{{ $publication->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $publication->name }}</h5>
                                <p><strong>Tipo:</strong> {{ $publication->type }}</p>
                                <p><strong>Tipo de Animal:</strong> {{ $publication->type_animal }}</p>
                                <p><strong>Tamaño:</strong> {{ $publication->size }}</p>
                                <p><strong>Fecha:</strong> {{ $publication->date }}</p>
                                <a href="{{ route('publications.show', $publication->id) }}" class="btn btn-primary">Ver
                                    Detalles</a>
                                <a href="{{ route('publications.edit', $publication->id) }}"
                                    class="btn btn-warning">Editar</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-id="{{ $publication->id }}">Eliminar</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar esta publicación?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const publicationId = button.getAttribute('data-id');
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/publications/${publicationId}`;
        });
    </script>
@endsection
