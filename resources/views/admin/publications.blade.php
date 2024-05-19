@extends('layout')

@section('content')
    <div class="container">
        <h1 class="my-3">Administrar Publicaciones</h1>

        <div class="mb-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Creado en</th>
                            <th>Actualizado en</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($publications as $publication)
                            <tr>
                                <td>{{ $publication->name }}</td>
                                <td>{{ $publication->user->username }}</td>
                                <td>{{ $publication->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $publication->updated_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('publications.show', $publication) }}"
                                        class="btn btn-sm btn-secondary">Mostrar</a>
                                    <a href="{{ route('publications.edit', $publication) }}"
                                        class="btn btn-sm btn-primary">Editar</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deletePublicationModal"
                                        data-publication-id="{{ $publication->id }}">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{ $publications->links() }}
                </div>
                <a class="btn btn-link" href="{{ route('index') }}">
                    Volver a inicio
                </a>
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
                var deletePublicationModal = document.getElementById('deletePublicationModal');
                var deletePublicationForm = document.getElementById('deletePublicationForm');

                deletePublicationModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var publicationId = button.getAttribute('data-publication-id');
                    deletePublicationForm.action = '/publications/' + publicationId;
                });
            });
        </script>
    </div>
@endsection
