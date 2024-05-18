@extends('layout')

@section('content')
    <div class="container">
        <h1 class="my-3">¿Quieres modificar tu perfil, <strong>{{ $user->username }}</strong>?</h1>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="username" class="form-label">Name</label>
                <input type="text" name="username" class="form-control" id="username"
                    value="{{ old('username', $user->username) }}" required>
                @if ($errors->has('username'))
                    <div class="text-danger">
                        {{ $errors->first('username') }}
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email"
                    value="{{ old('email', $user->email) }}" required>
                @if ($errors->has('email'))
                    <div class="text-danger">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" id="phone"
                    value="{{ old('phone', $user->phone) }}" required>
                @if ($errors->has('phone'))
                    <div class="text-danger">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password">
                <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
                @if ($errors->has('password'))
                    <div class="text-danger">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                @if ($errors->has('password_confirmation'))
                    <div class="text-danger">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                @endif
            </div>

            <a href="{{ route('index') }}" class="btn btn-secondary">Volver a Inicio</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
