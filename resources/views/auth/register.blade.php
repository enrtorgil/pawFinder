@extends('layout')

@section('title', 'Registro')

@section('content')
    <div class="container mt-3">
        <div class="row mb-1">
            <div class="col-md-12 text-center">
                <h2 class="mb-2">Bienvenido a PawFinder</h2>
                <p class="mb-3">Adopta o encuentra a tu mascota perdida</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">Regístrate</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-2">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label">Contraseña</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label for="password-confirm" class="form-label">Confirmar contraseña</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="mb-2">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input id="phone" type="text"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" required autocomplete="phone">
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <a class="btn btn-link" href="{{ route('index') }}">
                                    ¿Ya tienes cuenta? Inicia sesión
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Registrarse
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
