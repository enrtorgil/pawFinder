@extends('layout')

@section('content')
<div class="container">
    @if (Auth::check())
        <div class="row">
            <div class="col-md-12">
                <h1>Bienvenido, {{ Auth::user()->username }}</h1>
                <p>Explora nuestras publicaciones y más.</p>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <h1>Bienvenido a PawFinder</h1>
                <p>Encuentra tu mascota perdida o adopta una nueva.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Iniciar sesión</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Correo electrónico</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Recordarme
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Iniciar sesión
                                    </button>
                                    <a class="btn btn-link" href="{{ route('register') }}">
                                        ¿No tienes cuenta? Regístrate
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
