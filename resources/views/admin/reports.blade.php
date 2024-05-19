@extends('layout')

@section('content')
    <div class="container">
        <h1 class="my-3">Administrar Reportes</h1>

        <div class="mb-4">
            <h2>Reportes</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>De</th>
                            <th>Animal</th>
                            <th>Razón</th>
                            <th>Información Adicional</th>
                            <th>Creado en</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ $report->user->username }}</td>
                                <td>{{ $report->publication->name }}</td>
                                <td>{{ $report->reason }}</td>
                                <td class="text-truncate" style="max-width: 100%;">
                                    {{ Str::limit($report->additional_info, 30) }}
                                    @if (strlen($report->additional_info) > 30)
                                        <button type="button" class="btn btn-link p-0 m-0 align-baseline"
                                            style="display: inline;" data-bs-toggle="modal"
                                            data-bs-target="#additionalInfoModal"
                                            data-additional-info="{{ $report->additional_info }}">
                                            Leer más
                                        </button>
                                    @endif
                                </td>
                                <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('publications.show', $report->publication) }}"
                                        class="btn btn-sm btn-secondary">Mostrar</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteReportModal" data-report-id="{{ $report->id }}">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between">
                {{ $reports->links() }}
            </div>
        </div>

        <!-- Modal para Mostrar Información Adicional Completa -->
        <div class="modal fade" id="additionalInfoModal" tabindex="-1" aria-labelledby="additionalInfoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="additionalInfoModalLabel">Información Adicional</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="fullAdditionalInfo" class="text-wrap" style="white-space: pre-wrap; word-break: break-word;">
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var additionalInfoModal = document.getElementById('additionalInfoModal');
                additionalInfoModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var additionalInfo = button.getAttribute('data-additional-info');
                    var fullAdditionalInfo = document.getElementById('fullAdditionalInfo');
                    fullAdditionalInfo.textContent = additionalInfo;
                });
            });
        </script>
    </div>
@endsection
