@extends('layout')

@section('title', __('texts_create.title'))

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
                <h2 class="mb-3">{{ __('texts_create.header', ['username' => $creator_username]) }}</h2>
                <form action="{{ route('texts.store') }}" method="POST" id="messageForm">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $receiver_id }}">
                    <input type="hidden" name="phone" value="{{ $phone }}">
                    <div class="mb-3">
                        <label for="subject" class="form-label">{{ __('texts_create.subject') }}</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="short_description" class="form-label">{{ __('texts_create.description') }}</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="3" required></textarea>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('index') }}" class="btn btn-secondary flex-grow-1 m-1"><i
                                class='bx bx-arrow-back me-3 icon-center'></i>{{ __('texts_create.back_to_home') }}</a>
                        <button type="submit"
                            class="btn btn-primary flex-grow-1 m-1">{{ __('texts_create.send_message') }}</button>
                    </div>
                </form>
                <div class="alert alert-success text-center mt-3" role="alert">
                    {!! __('texts_create.alert_message') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
