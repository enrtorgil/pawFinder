@extends('layout')

@section('title', 'Enviar mensaje')

@section('content')
    <div class="container mt-5">
        <div class="row mt-3 justify-content-center">
            <div class="col-md-6 d-flex justify-content-center">
                <img src="{{ url('img/cat-message.png') }}" alt="Gato con sobre de mensaje" class="img-fluid"
                    style="max-width: 26rem;">
            </div>
            <div class="col-md-6">
                <h2 class="mb-3">Contactar con <strong>{{ $creator_username }}</strong></h2>
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
                    <a href="{{ url()->previous() }}" class="btn btn-secondary flex-grow-1 m-1"><i
                            class='bx bx-arrow-back'></i></a>
                    <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                </form>
                <p class="mt-3 text-muted">Al enviar este mensaje, aceptas que compartes tus datos con la persona
                    contactada, incluyendo tu teléfono de contacto, para agilizar la comunicación incluso fuera de la
                    aplicación si fuese necesario.</p>
            </div>
        </div>
    </div>
@endsection
