@extends('layout')

@section('title', 'Mis favoritos')

@section('content')
<div class="container">
    <h1>Mis Favoritos</h1>
    @if($favs->isEmpty())
        <p>No tienes publicaciones favoritas.</p>
    @else
        <div class="row">
            @foreach ($favs as $publication)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $publication->name }}</h5>
                            <p class="card-text">{{ $publication->description }}</p>
                            <form action="{{ route('publications.unfavorite', $publication->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Quitar de favoritos</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
