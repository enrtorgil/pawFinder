@extends('layout')

@section('title', 'PawFinder')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

@section('content')
    <div class="container-fluid px-5">
        @if (Auth::check())

            <div class="row mt-0">
                <div class="col-12">
                    <img src="{{ url('img/pet-banner-ia.png') }}" class="card-img banner-img p-0 mt-3" alt="Mascotas banner">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 mt-4">
                    <div class="card text-center d-flex justify-content-center align-items-center border-0 shadow bg-body rounded">
                        <div class="card-body">
                            <h1>Bienvenido, <strong>{{ Auth::user()->username }}</strong></h1>
                            <p>Explora nuestras publicaciones y más</p>
                            <ul class="list-group list-group-flush mt-4 mb-0">
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <i class='bx bx-list-ul me-3 text-success'></i>
                                    <a href="{{ route('publications.index') }}" class="text-decoration-none flex-grow-1">
                                        Ver Publicaciones
                                    </a>
                                </li>
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <i class='bx bx-envelope me-3 text-success'></i>
                                    <a href="{{ route('texts.index') }}" class="text-decoration-none flex-grow-1">
                                        Mensajes
                                    </a>
                                </li>
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <i class='bx bx-user me-3 text-success'></i>
                                    <a href="{{ route('users.edit', ['user' => Auth::user()->id]) }}"
                                        class="text-decoration-none flex-grow-1">
                                        Mi Perfil
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="w-75 pb-3">
                            <a href="{{ route('publications.create') }}" class="btn btn-primary btn-lg w-100"><i
                                    class='bx bx-up-arrow-alt me-3 icon-center'></i> Crear Publicación</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card text-center border-0">
                        @if ($mostFavsPublication)
                            <div class="card border-0 shadow bg-body rounded">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 mt-2"><i class="fas fa-fire me-3"></i> Publicación más
                                        popular, <strong>{{ $mostFavsPublication->name }}</strong></h5>
                                    <a href="{{ route('publications.show', $mostFavsPublication) }}">
                                        <img src="{{ Storage::url($mostFavsPublication->image) }}"
                                            class="card-img-top img-fluid rounded-circle img-custom hover-zoom"
                                            alt="{{ $mostFavsPublication->name }}">
                                    </a>
                                </div>
                                <div class="card-footer text-muted">
                                    Publicado {{ $mostFavsPublication->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @else
                            <p>No hay publicaciones disponibles.</p>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card text-center border-0">
                        @if ($latestPublication)
                            <div class="card border-0 shadow bg-body rounded">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 mt-2"><i class="fas fa-clock me-3"></i> Publicación más
                                        reciente, <strong>{{ $latestPublication->name }}</strong></h5>
                                    <a href="{{ route('publications.show', $latestPublication) }}">
                                        <img src="{{ Storage::url($latestPublication->image) }}"
                                            class="card-img-top img-fluid rounded-circle img-custom hover-zoom"
                                            alt="{{ $latestPublication->name }}">
                                    </a>
                                </div>
                                <div class="card-footer text-muted">
                                    Publicado {{ $latestPublication->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @else
                            <p>No hay publicaciones disponibles.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h1 class="mb-3">¡Bienvenido a PawFinder!</h1>
                        <p>Encuentra a tu mascota perdida o adopta una.</p>
                    </div>
                    <div>
                        <h2 class="mt-4">Preguntas Frecuentes</h2>
                        <div class="accordion mt-4" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                                        ¿Cómo puedo registrar una mascota perdida?
                                    </button>
                                </h2>
                                <div id="faqCollapse1" class="accordion-collapse collapse show"
                                    aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Para registrar una mascota perdida, debes crear una cuenta y completar el formulario
                                        de registro de mascota perdida en tu perfil.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                        ¿Cómo puedo adoptar una mascota?
                                    </button>
                                </h2>
                                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Puedes adoptar una mascota navegando en nuestra sección de adopciones y contactando
                                        al propietario.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                        ¿Qué debo hacer si encuentro una mascota perdida?
                                    </button>
                                </h2>
                                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Si encuentras una mascota perdida, puedes publicar un anuncio en nuestra sección de
                                        mascotas encontradas o contactar al propietario si la mascota está registrada.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse4" aria-expanded="false"
                                        aria-controls="faqCollapse4">
                                        ¿Cómo puedo contactar al propietario de una mascota?
                                    </button>
                                </h2>
                                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Para contactar al propietario de una mascota, debes iniciar sesión en tu cuenta y
                                        usar el botón de contacto en la publicación de la mascota.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading5">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse5" aria-expanded="false"
                                        aria-controls="faqCollapse5">
                                        ¿Qué información debo proporcionar al registrar una mascota perdida?
                                    </button>
                                </h2>
                                <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Al registrar una mascota perdida, debes proporcionar detalles como el nombre de la
                                        mascota, una descripción, una foto, y la última ubicación conocida.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading6">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse6" aria-expanded="false"
                                        aria-controls="faqCollapse6">
                                        ¿Cómo puedo actualizar la información de mi mascota?
                                    </button>
                                </h2>
                                <div id="faqCollapse6" class="accordion-collapse collapse" aria-labelledby="faqHeading6"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Para actualizar la información de tu mascota, inicia sesión en tu cuenta, ve a la sección de 'mis anuncios'
                                        y edita los detalles de tu mascota en la sección correspondiente.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card mt-2">
                        <div class="card-header text-center">Iniciar sesión</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-center mb-3">
                                        <img src="{{ url('img/cat-message.png') }}" alt="Iniciar sesión"
                                            class="img-fluid" style="width: 250px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center mb-3">
                                        <img src="{{ url('img/cat-pc-heart.png') }}" alt="Iniciar sesión"
                                            class="img-fluid" style="width: 240px;">
                                    </div>
                                </div>

                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
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
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Recordarme
                                    </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                                    <a class="btn btn-link" href="{{ route('register') }}">¿No tienes cuenta?
                                        Regístrate</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
