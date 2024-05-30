@extends('layout')

@section('title', __('index.title'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

@section('content')
    <div class="container-fluid px-5">
        @if (Auth::check())

            <div class="row mt-0">
                <div class="col-12">
                    <img src="{{ url('img/pet-banner.png') }}" class="card-img banner-img p-0 mt-3" alt="Mascotas banner">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 mt-3">
                    <div
                        class="card text-center d-flex justify-content-center align-items-center border-0 shadow bg-body rounded">
                        <div class="card-body">
                            <h1>{{ __('index.welcome', ['username' => Auth::user()->username]) }}</h1>
                            <p>{{ __('index.subtitle') }}</p>
                            <ul class="list-group list-group-flush mt-4 mb-0">
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <i class='bx bx-list-ul me-3 text-success'></i>
                                    <a href="{{ route('publications.index') }}" class="text-decoration-none flex-grow-1">
                                        {{ __('index.view_publications') }}
                                    </a>
                                </li>
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <i class='bx bx-envelope me-3 text-success'></i>
                                    <a href="{{ route('texts.index') }}" class="text-decoration-none flex-grow-1">
                                        {{ __('index.messages') }}
                                    </a>
                                </li>
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <i class='bx bx-user me-3 text-success'></i>
                                    <a href="{{ route('users.edit', ['user' => Auth::user()->id]) }}"
                                        class="text-decoration-none flex-grow-1">
                                        {{ __('index.my_profile') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="w-75 pb-3 mt-3">
                            <a href="{{ route('publications.create') }}" class="btn btn-primary btn-lg w-100"><i
                                    class='bx bx-up-arrow-alt me-3 icon-center'></i>
                                {{ __('index.create_publication') }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card text-center border-0">
                        @if ($mostFavsPublication)
                            <div class="card border-0 shadow bg-body rounded">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 mt-0"><i class="fas fa-fire me-3"></i>
                                        {{ __('index.most_popular_publication') }} <br>
                                        <strong>{{ $mostFavsPublication->name }}</strong></h5>
                                    <a href="{{ route('publications.show', $mostFavsPublication) }}">
                                        <img src="{{ Storage::url($mostFavsPublication->image) }}"
                                            class="card-img-top img-fluid rounded-circle img-custom hover-zoom"
                                            alt="{{ $mostFavsPublication->name }}">
                                    </a>
                                </div>
                                <div class="card-footer text-muted">
                                    {{ __('index.published', ['time_ago' => $mostFavsPublication->created_at->diffForHumans()]) }}
                                </div>
                            </div>
                        @else
                            <p>{{ __('index.no_publications') }}</p>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card text-center border-0">
                        @if ($latestPublication)
                            <div class="card border-0 shadow bg-body rounded">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 mt-0"><i class="fas fa-clock me-3"></i>
                                        {{ __('index.recent_publication') }} <br>
                                        <strong>{{ $latestPublication->name }}</strong></h5>
                                    <a href="{{ route('publications.show', $latestPublication) }}">
                                        <img src="{{ Storage::url($latestPublication->image) }}"
                                            class="card-img-top img-fluid rounded-circle img-custom hover-zoom"
                                            alt="{{ $latestPublication->name }}">
                                    </a>
                                </div>
                                <div class="card-footer text-muted">
                                    {{ __('index.published', ['time_ago' => $latestPublication->created_at->diffForHumans()]) }}
                                </div>
                            </div>
                        @else
                            <p>{{ __('index.no_publications') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h1 class="mb-3">{{ __('index.welcome_to') }} <strong>PawFinder</strong> !</h1>
                        <p>{{ __('index.adopt_find') }}</p>
                    </div>
                    <div>
                        <h2 class="mt-4">{{ __('index.faq_title') }}</h2>
                        <div class="accordion mt-4" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                                        {{ __('index.faq_register_pet') }}
                                    </button>
                                </h2>
                                <div id="faqCollapse1" class="accordion-collapse collapse show"
                                    aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {{ __('index.faq_register_pet_answer') }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                        {{ __('index.faq_adopt_pet') }}
                                    </button>
                                </h2>
                                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {{ __('index.faq_adopt_pet_answer') }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                        {{ __('index.faq_found_pet') }}
                                    </button>
                                </h2>
                                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {{ __('index.faq_found_pet_answer') }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse4" aria-expanded="false"
                                        aria-controls="faqCollapse4">
                                        {{ __('index.faq_contact_owner') }}
                                    </button>
                                </h2>
                                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {{ __('index.faq_contact_owner_answer') }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading5">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse5" aria-expanded="false"
                                        aria-controls="faqCollapse5">
                                        {{ __('index.faq_provide_info') }}
                                    </button>
                                </h2>
                                <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {{ __('index.faq_provide_info_answer') }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading6">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse6" aria-expanded="false"
                                        aria-controls="faqCollapse6">
                                        {{ __('index.faq_update_info') }}
                                    </button>
                                </h2>
                                <div id="faqCollapse6" class="accordion-collapse collapse" aria-labelledby="faqHeading6"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {{ __('index.faq_update_info_answer') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card mt-2">
                        <div class="card-header text-center">{{ __('index.login_header') }}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="text-center mb-2">
                                    <img src="{{ url('img/cat-login.png') }}" alt="Iniciar sesión"
                                        class="img-dog-login img-fluid">
                                </div>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('index.login_email') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('index.login_password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            {{ __('index.remember_me') }}
                                        </label>
                                    </div>
                                    <a class="btn btn-link"
                                        href="{{ route('register') }}">{{ __('index.no_account') }}</a>
                                </div>

                                <div class="align-items-center">
                                    <button type="submit"
                                        class="btn btn-primary w-100 mt-2">{{ __('index.sign_in') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
