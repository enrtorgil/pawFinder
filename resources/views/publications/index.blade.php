@extends('layout')

@section('content')
    <div class="container mt-5">
        <a href="{{ route('publications.create') }}" class="btn btn-primary">Crear Publicación</a>
        <div class="list-group">
            @foreach ($publications as $publication)
                <a href="{{ route('publications.show', $publication) }}" class="list-group-item list-group-item-action">
                    <h5 class="mb-1">{{ $publication->name }}</h5>
                    <p class="mb-1">{{ Str::limit($publication->description, 150) }}</p>
                    <small>{{ $publication->created_at->diffForHumans() }}</small>
                </a>
            @endforeach
        </div>
    </div>
@endsection
