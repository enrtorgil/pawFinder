@extends('layout')

@section('title', __('admin.publications.title'))

@section('content')
    <div class="container-fluid mt-3 px-5">
        <h1 class="mb-4">{{ __('admin.publications.title') }}</h1>

        <div class="mb-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">{{ __('admin.publications.name') }}</th>
                            <th class="ps-3">{{ __('admin.publications.user') }}</th>
                            <th class="ps-3">
                                {{ __('admin.publications.created_at') }}
                                <div class="float-end">
                                    <a href="{{ route('admin.publications', ['sort' => request('sort') === 'asc' ? 'desc' : 'asc', 'column' => 'created_at']) }}"
                                        class="btn btn-sm btn-link p-0 mx-2">
                                        <i class="fas fa-sort text-lightgreen"></i>
                                    </a>
                                </div>
                            </th>
                            <th class="ps-3">
                                {{ __('admin.publications.updated_at') }}
                                <div class="float-end">
                                    <a href="{{ route('admin.publications', ['sort' => request('sort') === 'asc' ? 'desc' : 'asc', 'column' => 'updated_at']) }}"
                                        class="btn btn-sm btn-link p-0 mx-2">
                                        <i class="fas fa-sort text-lightgreen"></i>
                                    </a>
                                </div>
                            </th>
                            <th class="text-center">{{ __('admin.publications.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($publications as $publication)
                            <tr>
                                <td class="ps-3">{{ $publication->name }}</td>
                                <td class="ps-3">{{ $publication->user->username }}</td>
                                <td class="text-nowrap ps-3">{{ $publication->created_at->format('d-m-Y H:i') }}</td>
                                <td class="text-nowrap ps-3">{{ $publication->updated_at->format('d-m-Y H:i') }}</td>
                                <td class="text-center d-flex justify-content-center gap-1 flex-wrap">
                                    <a href="{{ route('publications.show', $publication) }}"
                                        class="btn btn-sm btn-secondary flex-grow-1">
                                        <i class="bx bx-show"></i> {{ __('admin.publications.show') }}
                                    </a>
                                    <a href="{{ route('publications.edit', $publication) }}"
                                        class="btn btn-sm btn-primary flex-grow-1">
                                        <i class="bx bx-edit"></i> {{ __('admin.publications.edit') }}
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger flex-grow-1" data-bs-toggle="modal"
                                        data-bs-target="#deletePublicationModal"
                                        data-publication-id="{{ $publication->id }}">
                                        <i class="bx bx-trash"></i> {{ __('admin.publications.delete') }}
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
                <div class="ms-auto d-flex gap-2">
                    <a class="btn btn-secondary" href="{{ route('index') }}">
                        <i class="fas fa-arrow-left me-2"></i> {{ __('admin.publications.back_to_home') }}
                    </a>
                    <a class="btn btn-success" href="{{ route('admin.publications.export') }}">
                        <i class="fas fa-file-excel me-2"></i> {{ __('admin.publications.export') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación para Eliminar Publicación -->
        <div class="modal fade" id="deletePublicationModal" tabindex="-1" aria-labelledby="deletePublicationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePublicationModalLabel">
                            {{ __('admin.publications.confirm_delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('admin.publications.confirm_delete_message') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('admin.publications.cancel') }}</button>
                        <form id="deletePublicationForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('admin.publications.delete') }}</button>
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
