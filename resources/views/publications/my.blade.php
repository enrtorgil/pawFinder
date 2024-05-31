@extends('layout')

@section('title', __('publications_my.title'))

@section('content')
    <div class="container-fluid mt-3 px-5">
        <h1 class="mb-3">{{ __('publications_my.title') }}</h1>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <a href="{{ route('publications.create') }}" class="btn btn-primary">
                            <i class='bx bx-up-arrow-alt icon-center'></i> {{ __('publications_my.create_publication') }}
                        </a>
                    </div>
                    <div class="col">
                        <form method="GET" action="{{ route('publications.my') }}" class="row g-3">
                            <div class="col">
                                <input type="text" name="name" class="form-control"
                                    placeholder="{{ __('publications_my.name') }}" value="{{ request('name') }}">
                            </div>
                            <div class="col">
                                <select name="type" class="form-select">
                                    <option value="">{{ __('publications_my.type') }}</option>
                                    <option value="se busca" {{ request('type') == 'se busca' ? 'selected' : '' }}>
                                        {{ __('publications_my.type_seeking') }}
                                    </option>
                                    <option value="se adopta" {{ request('type') == 'se adopta' ? 'selected' : '' }}>
                                        {{ __('publications_my.type_adopt') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="type_animal" class="form-select">
                                    <option value="">{{ __('publications_my.animal_type') }}</option>
                                    <option value="perro" {{ request('type_animal') == 'perro' ? 'selected' : '' }}>
                                        {{ __('publications_my.animal_type_dog') }}
                                    </option>
                                    <option value="gato" {{ request('type_animal') == 'gato' ? 'selected' : '' }}>
                                        {{ __('publications_my.animal_type_cat') }}
                                    </option>
                                    <option value="otro" {{ request('type_animal') == 'otro' ? 'selected' : '' }}>
                                        {{ __('publications_my.animal_type_other') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="size" class="form-select">
                                    <option value="">{{ __('publications_my.size') }}</option>
                                    <option value="Grande" {{ request('size') == 'Grande' ? 'selected' : '' }}>
                                        {{ __('publications_my.size_large') }}
                                    </option>
                                    <option value="Mediano" {{ request('size') == 'Mediano' ? 'selected' : '' }}>
                                        {{ __('publications_my.size_medium') }}
                                    </option>
                                    <option value="Pequeño" {{ request('size') == 'Pequeño' ? 'selected' : '' }}>
                                        {{ __('publications_my.size_small') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="date" class="form-select">
                                    <option value="desc" {{ request('date') == 'desc' ? 'selected' : '' }}>
                                        {{ __('publications_my.most_recent') }}
                                    </option>
                                    <option value="asc" {{ request('date') == 'asc' ? 'selected' : '' }}>
                                        {{ __('publications_my.oldest') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class='bx bx-filter-alt'></i> {{ __('publications_my.filter') }}
                                </button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('publications.my') }}" class="btn btn-secondary w-100">
                                    <i class='bx bx-refresh'></i> {{ __('publications_my.reset') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($publications->isEmpty())
            <p>{{ __('publications_my.no_publications') }}</p>
        @else
            <div class="row">
                @foreach ($publications as $publication)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 bg-transparent">
                            <div class="card-header border-0 opacity-75 d-flex justify-content-between align-items-center py-2 header-shadow bg-success text-light">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('publications.show', $publication->id) }}"
                                        class="text-decoration-none text-reset">
                                        <h6 class="card-title mb-0 me-2">{{ $publication->name }}</h6>
                                    </a>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-secondary mx-3 p-2">{{ __('publications_my.publication.type.' . strtoupper($publication->type)) }}</span>
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
                                    class="card-img-top img-fluid img-custom border-0" alt="{{ $publication->name }}">
                            </a>
                            <div class="card-body p-2">
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="{{ route('publications.show', $publication->id) }}"
                                        class="btn btn-primary flex-grow-1 border-0 rounded-5">
                                        <i class='bx bx-show'></i> {{ __('publications_my.view') }}
                                    </a>
                                    <a href="{{ route('publications.edit', $publication->id) }}"
                                        class="btn btn-warning text-light flex-grow-1 border-0 rounded-5">
                                        <i class='bx bx-edit'></i> {{ __('publications_my.edit') }}
                                    </a>
                                    <button type="button" class="btn btn-danger flex-grow-1 border-0 rounded-5"
                                        data-bs-toggle="modal" data-id="{{ $publication->id }}"
                                        data-bs-target="#deleteModal">
                                        <i class='bx bx-trash'></i> {{ __('publications_my.delete') }}
                                    </button>
                                </div>
                            </div>
                            <div class="card-footer text-muted d-flex justify-content-between border-0 py-2 px-4 rounded-5 bg-success opacity-75">
                                <span class="text-light"><i class='bx bx-ruler'></i>
                                    {{ __('publications_my.publication.size.' . $publication->size) }}</span>
                                <span class="text-light"><i class='bx bx-calendar'></i>
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
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('publications_my.title.confirm_delete') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('publications_my.confirm_delete') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('publications_my.cancel') }}</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('publications_my.delete') }}</button>
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
            height: 18rem;
            object-fit: cover;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            border-top-left-radius: 0rem;
            border-top-right-radius: 0rem;
        }

        .header-shadow {
            box-shadow: 0 4px 8px -4px rgba(234, 220, 220, 0.8);
        }
    </style>
@endsection
