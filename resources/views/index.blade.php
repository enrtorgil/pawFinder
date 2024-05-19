@extends('layout')

@section('content')
    <div class="container mt-5">
        @if (Auth::check())
            <div class="row mb-3">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <h1>Bienvenido, {{ Auth::user()->username }}</h1>
                    <a href="{{ route('publications.create') }}" class="btn btn-primary"><i class='bx bx-plus'></i> Crear Publicación</a>
                </div>
                <p>Explora nuestras publicaciones y más.</p>
            </div>

            <!-- Última publicación -->
            <div class="row">
                <div class="col-md-12">
                    <h2>Última Publicación</h2>
                    @if ($latestPublication)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $latestPublication->name }}</h5>
                                <p class="card-text">{{ Str::limit($latestPublication->description, 150) }}</p>
                                <a href="{{ route('publications.show', $latestPublication) }}" class="btn btn-primary">Ver
                                    Detalles</a>
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
                                    <button type="submit" class="btn btn-primary">
                                        Iniciar sesión
                                    </button>
                                    <a class="btn btn-link" href="{{ route('register') }}">
                                        ¿No tienes cuenta? Regístrate
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
