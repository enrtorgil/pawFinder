@extends('layout')

@section('content')
    <div class="container mt-3">
        <h2 class="mb-3">Contactar con {{ $creator_username }}</h2>
        <form action="{{ route('texts.store') }}" method="POST">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $receiver_id }}">
            <input type="hidden" name="phone" value="{{ $phone }}"> <!-- Campo oculto para el teléfono -->
            <div class="mb-3">
                <label for="subject" class="form-label">Asunto</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="mb-3">
                <label for="short_description" class="form-label">Descripción</label>
                <textarea class="form-control" id="short_description" name="short_description" rows="3" required></textarea>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-secondary flex-grow-1 m-1"><i class='bx bx-arrow-back'></i></a>
            <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
        </form>
    </div>
@endsection
