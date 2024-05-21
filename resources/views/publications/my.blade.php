@extends('layout')

@section('title', 'Mis anuncios')

@section('content')
    <div class="container-fluid mt-4 px-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <a href="{{ route('publications.create') }}" class="btn btn-primary"><i class='bx bx-plus'></i> Crear
                            Publicación</a>
                    </div>
                    <div class="col">
                        <form method="GET" action="{{ route('publications.my') }}" class="row g-3">
                            <div class="col">
                                <input type="text" name="name" class="form-control" placeholder="Nombre"
                                    value="{{ request('name') }}">
                            </div>
                            <div class="col">
                                <select name="type" class="form-select">
                                    <option value="">Tipo</option>
                                    <option value="se busca" {{ request('type') == 'se busca' ? 'selected' : '' }}>Se busca
                                    </option>
                                    <option value="se adopta" {{ request('type') == 'se adopta' ? 'selected' : '' }}>Se
                                        adopta</option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="type_animal" class="form-select">
                                    <option value="">Tipo de Animal</option>
                                    <option value="perro" {{ request('type_animal') == 'perro' ? 'selected' : '' }}>Perro
                                    </option>
                                    <option value="gato" {{ request('type_animal') == 'gato' ? 'selected' : '' }}>Gato
                                    </option>
                                    <option value="otro" {{ request('type_animal') == 'otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="size" class="form-select">
                                    <option value="">Tamaño</option>
                                    <option value="Grande" {{ request('size') == 'Grande' ? 'selected' : '' }}>Grande
                                    </option>
                                    <option value="Mediano" {{ request('size') == 'Mediano' ? 'selected' : '' }}>Mediano
                                    </option>
                                    <option value="Pequeño" {{ request('size') == 'Pequeño' ? 'selected' : '' }}>Pequeño
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="date" class="form-select">
                                    <option value="desc" {{ request('date') == 'desc' ? 'selected' : '' }}>Más Recientes
                                    </option>
                                    <option value="asc" {{ request('date') == 'asc' ? 'selected' : '' }}>Más Antiguos
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary w-100"><i class='bx bx-filter-alt'></i>
                                    Filtrar</button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('publications.my') }}" class="btn btn-secondary w-100"><i
                                        class='bx bx-refresh'></i></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($publications->isEmpty())
            <p>No has publicado ningún anuncio.</p>
        @else
            <div class="row">
                @foreach ($publications as $publication)
                    <div class="col-md-3 mb-3">
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
                                <img src="{{ Storage::url($publication->image) }}"
                                    class="card-img-top img-fluid img-custom rounded-0" alt="{{ $publication->name }}">
                            </a>
                            <div class="card-body p-2">
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="{{ route('publications.show', $publication->id) }}"
                                        class="btn btn-primary flex-grow-1 border-0 rounded-5"><i
                                            class='bx bx-show'></i></a>
                                    <a href="{{ route('publications.edit', $publication->id) }}"
                                        class="btn btn-warning flex-grow-1 border-0 rounded-5"><i
                                            class='bx bx-edit'></i></a>
                                    <button type="button" class="btn btn-danger flex-grow-1 border-0 rounded-5"
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
