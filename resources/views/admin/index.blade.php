@extends('layout')

@section('content')
    <div class="container">

        <h1 class="my-3">Admin Dashboard</h1>

        <div class="mb-4">
            <h2>Users</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                @if (Auth::user()->role !== 'admin' || $user->role !== 'admin')
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">Edit</a>
                                @endif
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteUserModal" data-user-id="{{ $user->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h2>Publications</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>User</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($publications as $publication)
                        <tr>
                            <td>{{ $publication->name }}</td>
                            <td>{{ $publication->user->username }}</td>
                            <td>{{ $publication->created_at }}</td>
                            <td>{{ $publication->updated_at }}</td>
                            <td>
                                <a href="{{ route('publications.show', $publication) }}"
                                    class="btn btn-sm btn-secondary">Show</a>
                                <a href="{{ route('publications.edit', $publication) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deletePublicationModal"
                                    data-publication-id="{{ $publication->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h2>Reports</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Reporter</th>
                        <th>Report Content</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr>
                            <td>{{ $report->reporter }}</td>
                            <td>{{ $report->content }}</td>
                            <td>
                                <a href="{{ route('reports.edit', $report) }}" class="btn btn-sm btn-primary">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteReportModal"
                                    data-report-id="{{ $report->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Confirmación para Eliminar Usuario -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
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

    <!-- Modal de Confirmación para Eliminar Publicación -->
    <div class="modal fade" id="deletePublicationModal" tabindex="-1" aria-labelledby="deletePublicationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePublicationModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar esta publicación?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deletePublicationForm" method="POST">
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

            var deletePublicationModal = document.getElementById('deletePublicationModal');
            var deletePublicationForm = document.getElementById('deletePublicationForm');

            deletePublicationModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var publicationId = button.getAttribute('data-publication-id');
                deletePublicationForm.action = '/publications/' + publicationId;
            });
        });
    </script>
@endsection
