@extends('layout')

@section('title', __('admin.users.title'))

@section('content')
    <div class="container-fluid mt-3 px-5">
        <h1 class="mb-4">{{ __('admin.users.title') }}</h1>

        <div class="mb-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">{{ __('admin.users.name') }}</th>
                            <th class="ps-3">{{ __('admin.users.email') }}</th>
                            <th class="ps-3">{{ __('admin.users.role') }}</th>
                            <th class="ps-3">
                                {{ __('admin.users.created_at') }}
                                <div class="float-end">
                                    <a href="{{ route('admin.users', ['sort' => request('sort') === 'asc' ? 'desc' : 'asc', 'column' => 'created_at']) }}"
                                        class="btn btn-sm btn-link p-0 mx-2">
                                        <i class="fas fa-sort text-lightgreen"></i>
                                    </a>
                                </div>
                            </th>
                            <th class="ps-3">
                                {{ __('admin.users.updated_at') }}
                                <div class="float-end">
                                    <a href="{{ route('admin.users', ['sort' => request('sort') === 'asc' ? 'desc' : 'asc', 'column' => 'updated_at']) }}"
                                        class="btn btn-sm btn-link p-0 mx-2">
                                        <i class="fas fa-sort text-lightgreen"></i>
                                    </a>
                                </div>
                            </th>
                            <th class="text-center">{{ __('admin.users.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="ps-3">{{ $user->username }}</td>
                                <td class="ps-3">{{ $user->email }}</td>
                                <td class="ps-3">{{ $user->role }}</td>
                                <td class="text-nowrap ps-3">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                                <td class="text-nowrap ps-3">{{ $user->updated_at->format('d-m-Y H:i') }}</td>
                                <td class="text-center d-flex justify-content-center gap-1 flex-wrap">
                                    @if (Auth::user()->role !== 'admin' || $user->role !== 'admin')
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="btn btn-sm btn-primary flex-grow-1">
                                            <i class='bx bx-edit'></i> {{ __('admin.users.edit') }}
                                        </a>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-danger flex-grow-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal" data-user-id="{{ $user->id }}">
                                        <i class='bx bx-trash'></i> {{ __('admin.users.delete') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-1 mb-2">
                <div>
                    {{ $users->links() }}
                </div>
                <div class="ms-auto d-flex gap-2">
                    <a class="btn btn-secondary" href="{{ route('index') }}">
                        <i class="fas fa-arrow-left me-2"></i> {{ __('admin.users.back_to_home') }}
                    </a>
                    <a class="btn btn-success" href="{{ route('admin.users.export') }}">
                        <i class="fas fa-file-excel me-2"></i> {{ __('admin.users.export') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación para Eliminar Usuario -->
        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">{{ __('admin.users.confirm_delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('admin.users.confirm_delete_message') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('admin.users.cancel') }}</button>
                        <form id="deleteUserForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('admin.users.delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let deleteUserModal = document.getElementById('deleteUserModal');
                let deleteUserForm = document.getElementById('deleteUserForm');

                deleteUserModal.addEventListener('show.bs.modal', function(event) {
                    let button = event.relatedTarget;
                    let userId = button.getAttribute('data-user-id');
                    deleteUserForm.action = '/users/' + userId;
                });
            });
        </script>
    </div>
@endsection
