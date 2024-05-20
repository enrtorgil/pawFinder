@extends('layout')

@section('title', 'Mis anuncios')

@section('content')
    <div class="container mt-4">

        @if ($publications->isEmpty())
            <p>No has publicado ningún anuncio.</p>
        @else
            <div class="row">
                @foreach ($publications as $publication)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('publications.show', $publication->id) }}"
                                        class="text-decoration-none text-reset">
                                        <h6 class="card-title mb-0 me-2">{{ $publication->name }}</h6>
                                    </a>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-secondary mx-3">{{ strtoupper($publication->type) }}</span>
                                    @if ($publication->type_animal == 'perro')
                                        <i class='bx bxs-dog'></i>
                                    @elseif ($publication->type_animal == 'gato')
                                        <i class='bx bxs-cat'></i>
                                    @else
                                        <i class="fas fa-question-circle"></i>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('publications.show', $publication->id) }}">
                                <img src="{{ Storage::url($publication->image) }}" class="card-img-top img-fluid img-custom"
                                    alt="{{ $publication->name }}">
                            </a>
                            <div class="card-body p-1">
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="{{ route('publications.show', $publication->id) }}"
                                        class="btn btn-primary flex-grow-1 border-0 rounded-0"><i
                                            class='bx bx-show'></i></a>
                                    <a href="{{ route('publications.edit', $publication->id) }}"
                                        class="btn btn-warning flex-grow-1 border-0 rounded-0"><i
                                            class='bx bx-edit'></i></a>
                                    <button type="button" class="btn btn-danger flex-grow-1 border-0 rounded-0"
                                        data-bs-toggle="modal" data-id="{{ $publication->id }}"
                                        data-bs-target="#deleteModal"><i class='bx bx-trash'></i></button>
                                </div>
                            </div>
                            <div class="card-footer text-muted d-flex justify-content-between">
                                <span><i class='bx bx-ruler'></i> {{ $publication->size }}</span>
                                <span><i class='bx bx-calendar'></i>
                                    {{ \Carbon\Carbon::parse($publication->date)->format('d-m-Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mb-4">
                {{ $publications->links() }}
            </div>
        @endif
    </div>

    <!-- Modal para eliminar -->
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

    <style>
        .img-custom {
            width: 100%;
            height: 14rem;
            object-fit: cover;
        }
    </style>
@endsection
