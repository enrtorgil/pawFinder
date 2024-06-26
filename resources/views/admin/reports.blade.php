@extends('layout')

@section('title', __('admin.reports.title'))

@section('content')
    <div class="container-fluid mt-3 px-5">
        <h2 class="mb-4">{{ __('admin.reports.title') }}</h2>

        <div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">{{ __('admin.reports.from') }}</th>
                            <th class="ps-3">{{ __('admin.reports.animal') }}</th>
                            <th class="ps-3">
                                {{ __('admin.reports.reason') }}
                                <div class="float-end">
                                    <a href="{{ route('admin.reports', ['sort' => request('sort') === 'asc' ? 'desc' : 'asc', 'column' => 'reason']) }}"
                                        class="btn btn-sm btn-link p-0 mx-2">
                                        <i class="fas fa-sort text-lightgreen"></i>
                                    </a>
                                </div>
                            </th>
                            <th class="ps-3">{{ __('admin.reports.additional_info') }}</th>
                            <th class="ps-3">
                                {{ __('admin.reports.created_at') }}
                                <div class="float-end">
                                    <a href="{{ route('admin.reports', ['sort' => request('sort') === 'asc' ? 'desc' : 'asc', 'column' => 'created_at']) }}"
                                        class="btn btn-sm btn-link p-0 mx-2">
                                        <i class="fas fa-sort text-lightgreen"></i>
                                    </a>
                                </div>
                            </th>
                            <th class="text-center">{{ __('admin.reports.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td class="ps-3">{{ $report->username }}</td>
                                <td class="ps-3">{{ $report->publication_name }}</td>
                                <td class="ps-3">{{ $report->reason }}</td>
                                <td class="text-truncate ps-3" style="max-width: 100%;">
                                    {{ Str::limit($report->additional_info, 30) }}
                                    @if (strlen($report->additional_info) > 30)
                                        <button type="button" class="btn btn-link p-0 m-0 align-baseline text-darkgreen"
                                            style="display: inline;" data-bs-toggle="modal"
                                            data-bs-target="#additionalInfoModal"
                                            data-additional-info="{{ $report->additional_info }}">
                                            {{ __('admin.reports.read_more') }}
                                        </button>
                                    @endif
                                </td>
                                <td class="text-nowrap ps-3">
                                    {{ \Carbon\Carbon::parse($report->created_at)->format('d-m-Y H:i') }}</td>
                                <td class="text-center d-flex justify-content-center gap-1 flex-wrap">
                                    <a href="{{ route('publications.show', $report->publication_id) }}"
                                        class="btn btn-sm btn-secondary flex-grow-1">
                                        <i class="bx bx-show"></i> {{ __('admin.reports.show') }}
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger flex-grow-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteReportModal"
                                        data-publication-id="{{ $report->publication_id }}"
                                        data-user-id="{{ $report->user_id }}" data-created-at="{{ $report->created_at }}">
                                        <i class="bx bx-trash"></i> {{ __('admin.reports.delete') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-1 mb-2">
                <div>
                    {{ $reports->links() }}
                </div>
                <div class="ms-auto d-flex gap-2">
                    <a class="btn btn-secondary" href="{{ route('index') }}">
                        <i class="fas fa-arrow-left me-2"></i> {{ __('admin.reports.back_to_home') }}
                    </a>
                    <a class="btn btn-success" href="{{ route('admin.reports.export') }}">
                        <i class="fas fa-file-excel me-2"></i> {{ __('admin.reports.export') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal para Mostrar Información Adicional Completa -->
        <div class="modal fade" id="additionalInfoModal" tabindex="-1" aria-labelledby="additionalInfoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="additionalInfoModalLabel">{{ __('admin.reports.additional_info') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="fullAdditionalInfo" class="text-wrap" style="white-space: pre-wrap; word-break: break-word;">
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('admin.reports.close') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación para Eliminar Reporte -->
        <div class="modal fade" id="deleteReportModal" tabindex="-1" aria-labelledby="deleteReportModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteReportModalLabel">{{ __('admin.reports.confirm_delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('admin.reports.confirm_delete_message') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('admin.reports.cancel') }}</button>
                        <form id="deleteReportForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('admin.reports.delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let additionalInfoModal = document.getElementById('additionalInfoModal');
                additionalInfoModal.addEventListener('show.bs.modal', function(event) {
                    let button = event.relatedTarget;
                    let additionalInfo = button.getAttribute('data-additional-info');
                    let fullAdditionalInfo = document.getElementById('fullAdditionalInfo');
                    fullAdditionalInfo.textContent = additionalInfo;
                });

                let deleteReportModal = document.getElementById('deleteReportModal');
                let deleteReportForm = document.getElementById('deleteReportForm');

                deleteReportModal.addEventListener('show.bs.modal', function(event) {
                    let button = event.relatedTarget;
                    let publicationId = button.getAttribute('data-publication-id');
                    let userId = button.getAttribute('data-user-id');
                    let createdAt = button.getAttribute('data-created-at');
                    deleteReportForm.action = `/reports/${publicationId}/${userId}/${createdAt}`;
                });
            });
        </script>
    </div>
@endsection
