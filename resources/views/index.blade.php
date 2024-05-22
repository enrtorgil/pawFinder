@extends('layout')

@section('title', 'PawFinder')

@section('content')
    <div class="container-fluid px-5">
        @if (Auth::check())

            <div class="row mt-0">
                <div class="col-12 p-0">
                    <img src="{{ url('img/pets-banner.jpg') }}" class="card-img banner-img p-0 m-0" alt="Mascotas banner">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 mt-3">
                    <div class="card h-100 text-center d-flex justify-content-center align-items-center border-0">
                        <div class="card-body">
                            <h1>Bienvenido, <strong>{{ Auth::user()->username }}</strong></h1>
                            <p>Explora nuestras publicaciones y más</p>
                            <ul class="list-group list-group-flush mt-4">
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <i class='bx bx-list-ul me-3 text-primary'></i>
                                    <a href="{{ route('publications.index') }}" class="text-decoration-none flex-grow-1">
                                        Ver Publicaciones
                                    </a>
                                </li>
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <i class='bx bx-envelope me-3 text-primary'></i>
                                    <a href="{{ route('texts.index') }}" class="text-decoration-none flex-grow-1">
                                        Mensajes
                                    </a>
                                </li>
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <i class='bx bx-user me-3 text-primary'></i>
                                    <a href="{{ route('users.edit', ['user' => Auth::user()->id]) }}"
                                        class="text-decoration-none flex-grow-1">
                                        Mi Perfil
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body text-center border-0 bg-transparent w-75">
                            <a href="{{ route('publications.create') }}" class="btn btn-primary opacity-75 btn-lg w-100"><i
                                    class='bx bx-up-arrow-alt me-3'></i> Crear Publicación</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card h-100 text-center border-0">
                        @if ($mostFavsPublication)
                            <div class="card border-0 shadow my-2 bg-body rounded">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 mt-2"><i class="fas fa-fire me-3"></i> Publicación más
                                        popular, <strong>{{ $mostFavsPublication->name }}</strong></h5>
                                    <a href="{{ route('publications.show', $mostFavsPublication) }}">
                                        <img src="{{ Storage::url($mostFavsPublication->image) }}"
                                            class="card-img-top img-fluid rounded-circle img-custom"
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

                <div class="col-md-4 mt-3">
                    <div class="card h-100 text-center border-0">
                        @if ($latestPublication)
                            <div class="card border-0 shadow my-2 bg-body rounded">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 mt-2"><i class="fas fa-clock me-3"></i> Publicación más
                                        reciente, <strong>{{ $latestPublication->name }}</strong></h5>
                                    <a href="{{ route('publications.show', $latestPublication) }}">
                                        <img src="{{ Storage::url($latestPublication->image) }}"
                                            class="card-img-top img-fluid rounded-circle img-custom"
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
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h1>Bienvenido a PawFinder</h1>
                        <p>Encuentra tu mascota perdida o adopta una nueva.</p>
                    </div>
                    <div>
                        <h2>Preguntas Frecuentes</h2>
                        <div class="accordion mt-3" id="faqAccordion">
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
                            <!-- Agrega más preguntas frecuentes aquí -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">Iniciar sesión</div>
                        <div class="card-body">
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
    <style>
        .img-custom {
            width: 15rem;
            height: 15rem;
            margin: 0 auto;
        }

        .banner-img {
            height: 14rem;
            object-fit: cover;
        }
    </style>
@endsection
