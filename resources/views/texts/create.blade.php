@extends('layout')

@section('title', 'Enviar mensaje')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/texts-create.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <div class="row mt-3 justify-content-center">
            <div class="col-md-6 d-flex">
                <img src="{{ url('img/cat-message-create.png') }}" alt="Gato con sobre de mensaje"
                    class="img-fluid rounded-image">
            </div>
            <div class="col-md-6">
                <h2 class="mb-3">Contactar con <strong>{{ $creator_username }}</strong></h2>
                <form action="{{ route('texts.store') }}" method="POST" id="messageForm">
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
                    <div class="d-flex">
                        <a href="{{ route('index') }}" class="btn btn-secondary flex-grow-1 m-1"><i
                                class='bx bx-arrow-back me-3 icon-center'></i>Volver a inicio</a>
                        <button type="submit" class="btn btn-primary flex-grow-1 m-1">Enviar Mensaje</button>
                    </div>
                </form>
                <div class="alert alert-success text-center mt-3" role="alert">
                    Al enviar este mensaje, <strong>compartirás</strong> tus datos con la persona contactada. <br><br>
                    Esto incluye tu <strong>número de teléfono</strong>, para facilitar la comunicación, incluso fuera de la
                    aplicación si fuese necesario.
                </div>
                <div class="alert alert-success mt-3" id="successMessage" style="display: none;">
                    ¡Mensaje enviado con éxito!
                </div>
            </div>
        </div>
    </div>

@endsection
