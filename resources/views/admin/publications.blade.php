@extends('layout')

@section('title', 'Panel publicaciones')

@section('content')
    <div class="container">
        <h1 class="my-3">Administrar Publicaciones</h1>

        <div class="mb-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Nombre</th>
                            <th class="ps-3">Usuario</th>
                            <th class="ps-3">
                                Creado en
                                <div class="float-end">
                                    <a href="{{ route('admin.publications', ['sort' => request('sort') === 'asc' ? 'desc' : 'asc', 'column' => 'created_at']) }}"
                                        class="btn btn-sm btn-link p-0 mx-2">
                                        <i class="fas fa-sort"></i>
                                    </a>
                                </div>
                            </th>
                            <th class="ps-3">
                                Actualizado en
                                <div class="float-end">
                                    <a href="{{ route('admin.publications', ['sort' => request('sort') === 'asc' ? 'desc' : 'asc', 'column' => 'updated_at']) }}"
                                        class="btn btn-sm btn-link p-0 mx-2">
                                        <i class="fas fa-sort"></i>
                                    </a>
                                </div>
                            </th>
                            <th class="text-center justify-content-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($publications as $publication)
                            <tr>
                                <td class="ps-3">{{ $publication->name }}</td>
                                <td class="ps-3">{{ $publication->user->username }}</td>
                                <td class="text-nowrap ps-3">{{ $publication->created_at->format('d-m-Y H:i') }}</td>
                                <td class="text-nowrap ps-3">{{ $publication->updated_at->format('d-m-Y H:i') }}</td>
                                <td class="text-center d-flex justify-content-center gap-1">
                                    <a href="{{ route('publications.show', $publication) }}"
                                        class="btn btn-sm btn-secondary">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="{{ route('publications.edit', $publication) }}" class="btn btn-sm btn-primary">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deletePublicationModal"
                                        data-publication-id="{{ $publication->id }}">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-1 mb-2">
                <div>
                    {{ $publications->links() }}
                </div>
                <a class="btn btn-secondary" href="{{ route('index') }}">
                    <i class="fas fa-arrow-left"></i> Volver a inicio
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
                let deletePublicationModal = document.getElementById('deletePublicationModal');
                let deletePublicationForm = document.getElementById('deletePublicationForm');

                deletePublicationModal.addEventListener('show.bs.modal', function(event) {
                    let button = event.relatedTarget;
                    let publicationId = button.getAttribute('data-publication-id');
                    deletePublicationForm.action = '/publications/' + publicationId;
                });
            });
        </script>
    </div>
@endsection
