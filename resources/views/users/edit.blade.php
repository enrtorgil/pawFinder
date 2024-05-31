@extends('layout')

@section('title', __('edit_user.title'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/edit-user.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-7">
                <h1 class="mb-3">{{ __('edit_user.header', ['username' => $user->username]) }}</h1>
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="username" class="form-label">{{ __('edit_user.username') }}</label>
                        <input type="text" name="username" class="form-control" id="username"
                            value="{{ old('username', $user->username) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('edit_user.email') }}</label>
                        <input type="email" name="email" class="form-control" id="email"
                            value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('edit_user.phone') }}</label>
                        <input type="text" name="phone" class="form-control" id="phone"
                            value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('edit_user.password') }}</label>
                        <input type="password" name="password" class="form-control" id="password">
                        <small class="form-text text-muted">{{ __('edit_user.password_hint') }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation"
                            class="form-label">{{ __('edit_user.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a class="btn btn-secondary me-2" href="{{ route('index') }}">
                                <i class="fas fa-arrow-left"></i> {{ __('edit_user.back_to_home') }}
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteAccountModal">
                                {{ __('edit_user.delete_account') }}
                            </button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">{{ __('edit_user.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5 d-none d-md-flex mt-5 pt-5 ps-5">
                <img src="{{ url('img/edit-profile.png') }}" alt="Perfil de usuario" class="img-edit-user img-fluid">
            </div>
        </div>
    </div>

    <!-- Modal para Confirmar Eliminación de Cuenta -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">{{ __('edit_user.delete_account_modal_title') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('edit_user.delete_account_modal_body') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('edit_user.cancel') }}</button>
                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('edit_user.confirm_delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
