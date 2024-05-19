@extends('layout')

@section('content')
    <div class="container">
        <h1 class="my-3">Administrar Usuarios</h1>

        <div class="mb-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Creado en</th>
                            <th>Actualizado en</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $user->updated_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    @if (Auth::user()->role !== 'admin' || $user->role !== 'admin')
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">Editar</a>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal"
                                        data-user-id="{{ $user->id }}">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{ $users->links() }}
                </div>
                <a class="btn btn-link" href="{{ route('index') }}">
                    Volver a inicio
                </a>
            </div>
        </div>

        <!-- Modal de Confirmación para Eliminar Usuario -->
        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar este usuario?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form id="deleteUserForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var deleteUserModal = document.getElementById('deleteUserModal');
                var deleteUserForm = document.getElementById('deleteUserForm');

                deleteUserModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var userId = button.getAttribute('data-user-id');
                    deleteUserForm.action = '/users/' + userId;
                });
            });
        </script>
    </div>
@endsection
