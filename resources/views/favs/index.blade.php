@extends('layout')

@section('title', __('favs_index.title'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/favs-my.css') }}">
@endpush

@section('content')
    <div class="container-fluid mt-3 px-5">
        <h1 class="mb-3">{{ __('favs_index.title') }}</h1>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="row g-3 align-items-center">
                    <div class="col">
                        <form method="GET" action="{{ route('favs.index') }}" class="row g-3">
                            <div class="col">
                                <input type="text" name="name" class="form-control"
                                    placeholder="{{ __('favs_index.name') }}" value="{{ request('name') }}">
                            </div>
                            <div class="col">
                                <select name="type" class="form-select">
                                    <option value="">{{ __('favs_index.type') }}</option>
                                    <option value="se busca" {{ request('type') == 'se busca' ? 'selected' : '' }}>
                                        {{ __('favs_index.type_values.se_busca') }}
                                    </option>
                                    <option value="se adopta" {{ request('type') == 'se adopta' ? 'selected' : '' }}>
                                        {{ __('favs_index.type_values.se_adopta') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="type_animal" class="form-select">
                                    <option value="">{{ __('favs_index.animal_type') }}</option>
                                    <option value="perro" {{ request('type_animal') == 'perro' ? 'selected' : '' }}>
                                        {{ __('favs_index.animal_type_values.perro') }}
                                    </option>
                                    <option value="gato" {{ request('type_animal') == 'gato' ? 'selected' : '' }}>
                                        {{ __('favs_index.animal_type_values.gato') }}
                                    </option>
                                    <option value="otro" {{ request('type_animal') == 'otro' ? 'selected' : '' }}>
                                        {{ __('favs_index.animal_type_values.otro') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="size" class="form-select">
                                    <option value="">{{ __('favs_index.size') }}</option>
                                    <option value="Grande" {{ request('size') == 'Grande' ? 'selected' : '' }}>
                                        {{ __('favs_index.publication_size.grande') }}
                                    </option>
                                    <option value="Mediano" {{ request('size') == 'Mediano' ? 'selected' : '' }}>
                                        {{ __('favs_index.publication_size.mediano') }}
                                    </option>
                                    <option value="Pequeño" {{ request('size') == 'Pequeño' ? 'selected' : '' }}>
                                        {{ __('favs_index.publication_size.pequeño') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="date" class="form-select">
                                    <option value="desc" {{ request('date') == 'desc' ? 'selected' : '' }}>
                                        {{ __('favs_index.most_recent') }}</option>
                                    <option value="asc" {{ request('date') == 'asc' ? 'selected' : '' }}>
                                        {{ __('favs_index.oldest') }}</option>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary w-100"><i class='bx bx-filter-alt'></i>
                                    {{ __('favs_index.filter') }}</button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('favs.index') }}" class="btn btn-pastel-blue w-100"><i
                                        class='bx bx-refresh'></i> {{ __('favs_index.reset') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($favs->isEmpty())
            <p>{{ __('favs_index.no_favorites') }}</p>
        @else
            <div class="row">
                @foreach ($favs as $publication)
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
                                    <span class="badge bg-secondary mx-3 p-2">{{ __('favs_index.type_values.' . $publication->type) }}</span>
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
                                        class="btn btn-primary flex-grow-1 border-0 rounded-5"><i class='bx bx-show'></i>
                                        {{ __('favs_index.view') }}</a>

                                    @php
                                        $isFavorited = Auth::user()->favs->contains($publication->id);
                                    @endphp

                                    <form
                                        action="{{ $isFavorited ? route('publications.unfavorite', $publication->id) : route('publications.favorite', $publication->id) }}"
                                        method="POST" class="d-inline flex-grow-1 m-0">
                                        @csrf
                                        @if ($isFavorited)
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-report w-100 border-0 rounded-5"><i
                                                    class='bx bxs-heart'></i> {{ __('favs_index.unfavorite') }}</button>
                                        @else
                                            <button type="submit" class="btn btn-report w-100 border-0 rounded-5"><i
                                                    class='bx bx-heart'></i></button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                            <div
                                class="card-footer text-muted d-flex justify-content-between border-0 py-2 px-4 rounded-5 bg-success opacity-75">
                                <span class="text-light"><i class='bx bx-ruler'></i>
                                    {{ __('favs_index.publication_size.' . strtolower($publication->size)) }}</span>
                                <span class="text-light"><i class='bx bx-calendar'></i>
                                    {{ \Carbon\Carbon::parse($publication->date)->format('d-m-Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mb-4">
                {{ $favs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
