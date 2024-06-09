@extends('layout')

@section('title', __('publications_index.title'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/index-publications.css') }}">
@endpush

@section('content')
    <div class="container-fluid mt-4 px-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <a href="{{ route('publications.create') }}" class="btn btn-primary">
                            <i class='bx bx-up-arrow-alt icon-center'></i> {{ __('publications_index.create_publication') }}
                        </a>
                    </div>
                    <div class="col">
                        <form method="GET" action="{{ route('publications.index') }}" class="row g-3">
                            <div class="col">
                                <input type="text" name="name" class="form-control"
                                    placeholder="{{ __('publications_index.name') }}" value="{{ request('name') }}">
                            </div>
                            <div class="col">
                                <select name="type" class="form-select">
                                    <option value="">{{ __('publications_index.type') }}</option>
                                    <option value="se busca" {{ request('type') == 'se busca' ? 'selected' : '' }}>
                                        {{ __('publications_index.type_seeking') }}
                                    </option>
                                    <option value="se adopta" {{ request('type') == 'se adopta' ? 'selected' : '' }}>
                                        {{ __('publications_index.type_adopt') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="type_animal" class="form-select">
                                    <option value="">{{ __('publications_index.animal_type') }}</option>
                                    <option value="perro" {{ request('type_animal') == 'perro' ? 'selected' : '' }}>
                                        {{ __('publications_index.animal_type_dog') }}
                                    </option>
                                    <option value="gato" {{ request('type_animal') == 'gato' ? 'selected' : '' }}>
                                        {{ __('publications_index.animal_type_cat') }}
                                    </option>
                                    <option value="otro" {{ request('type_animal') == 'otro' ? 'selected' : '' }}>
                                        {{ __('publications_index.animal_type_other') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="size" class="form-select">
                                    <option value="">{{ __('publications_index.size') }}</option>
                                    <option value="Grande" {{ request('size') == 'Grande' ? 'selected' : '' }}>
                                        {{ __('publications_index.size_large') }}
                                    </option>
                                    <option value="Mediano" {{ request('size') == 'Mediano' ? 'selected' : '' }}>
                                        {{ __('publications_index.size_medium') }}
                                    </option>
                                    <option value="Pequeño" {{ request('size') == 'Pequeño' ? 'selected' : '' }}>
                                        {{ __('publications_index.size_small') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="date" class="form-select">
                                    <option value="desc" {{ request('date') == 'desc' ? 'selected' : '' }}>
                                        <i class='bx bx-sort-down'></i> {{ __('publications_index.most_recent') }}
                                    </option>
                                    <option value="asc" {{ request('date') == 'asc' ? 'selected' : '' }}>
                                        <i class='bx bx-sort-up'></i> {{ __('publications_index.oldest') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class='bx bx-filter-alt'></i> {{ __('publications_index.filter') }}
                                </button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('publications.index') }}" class="btn btn-pastel-blue w-100">
                                    <i class='bx bx-refresh'></i> {{ __('publications_index.reset') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($publications as $publication)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 bg-transparent">
                        <div
                            class="card-header border-0 opacity-75 d-flex justify-content-between align-items-center py-2 header-shadow bg-success text-light">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('publications.show', $publication->id) }}"
                                    class="text-decoration-none text-reset">
                                    <h6 class="card-title mb-0 me-2">{{ $publication->name }}</h6>
                                </a>
                            </div>
                            <div class="d-flex align-items-center">
                                <span
                                    class="badge bg-secondary mx-3 p-2">{{ __('publications_index.publication.type.' . strtoupper($publication->type)) }}</span>
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
                                class="card-img-top img-fluid img-custom border-0" alt="{{ $publication->name }}"></a>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-1">
                                <a href="{{ route('publications.show', $publication->id) }}"
                                    class="btn btn-primary flex-grow-1 border-0 rounded-5">
                                    <i class='bx bx-show'></i> {{ __('publications_index.view') }}
                                </a>
                                <a href="{{ route('texts.create', ['publication_id' => $publication->id]) }}"
                                    class="btn btn-pastel-green text-light flex-grow-1 border-0 rounded-5">
                                    <i class='bx bx-envelope'></i> {{ __('publications_index.message') }}
                                </a>
                                <button type="button" class="btn btn-pastel-red text-light flex-grow-1 border-0 rounded-5"
                                    data-bs-toggle="modal" data-id="{{ $publication->id }}" data-bs-target="#reportModal">
                                    <i class='bx bx-flag'></i> {{ __('publications_index.report') }}
                                </button>

                                @php
                                    $isFavorited = Auth::user()->favs->contains($publication->id);
                                @endphp

                                <form
                                    action="{{ $isFavorited ? route('publications.unfavorite', $publication->id) : route('publications.favorite', $publication->id) }}"
                                    method="POST" class="d-inline flex-grow-1 m-0">
                                    @csrf
                                    @if ($isFavorited)
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-favorite w-100 border-0 rounded-5">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-unfavorite w-100 border-0 rounded-5">
                                            <i class="far fa-star"></i>
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <div
                            class="card-footer text-muted d-flex justify-content-between border-0 py-2 px-4 rounded-5 bg-success opacity-75">
                            <span class="text-light"><i class='bx bx-ruler'></i>
                                {{ __('publications_index.publication.size.' . $publication->size) }}</span>
                            <span class="text-light"><i class='bx bx-calendar'></i>
                                {{ \Carbon\Carbon::parse($publication->date)->format('d-m-Y') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p>{{ __('publications_index.no_publications') }}</p>
            @endforelse
        </div>
        <div>
            {{ $publications->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Modal para reportar -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">{{ __('publications_index.report_publication') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reason" class="form-label">{{ __('publications_index.report_reason') }}</label>
                            <select class="form-select" id="reason" name="reason" required>
                                <option value="Contenido inapropiado">
                                    {{ __('publications_index.report_reason_inappropriate') }}</option>
                                <option value="Información incorrecta">
                                    {{ __('publications_index.report_reason_incorrect') }}</option>
                                <option value="Spam">{{ __('publications_index.report_reason_spam') }}</option>
                                <option value="Otra razón">{{ __('publications_index.report_reason_other') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="additional_info"
                                class="form-label">{{ __('publications_index.additional_info') }}</label>
                            <textarea class="form-control" id="additional_info" name="additional_info" rows="3" maxlength="200"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">{{ __('publications_index.send_report') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let reportModal = document.getElementById('reportModal');
            reportModal.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;
                let publicationId = button.getAttribute('data-id');
                let reportForm = document.getElementById('reportForm');
                reportForm.action = '/publications/' + publicationId + '/report';
            });
        });
    </script>
@endsection
