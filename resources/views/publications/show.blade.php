@extends('layout')

@section('title', $publication->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/show-publications.css') }}">
@endpush

@section('content')
    <div class="container-fluid mt-5 px-5">
        <div class="row mb-2">
            <div class="col-md-6">
                <img src="{{ Storage::url($publication->image) }}" class="img-fluid img-custom rounded-5" alt="{{ $publication->name }}">
                <div class="d-flex justify-content-between mt-2">
                    <a href="{{ route('texts.create', ['publication_id' => $publication->id]) }}" class="btn btn-pastel-green text-light flex-grow-1 m-1">
                        <i class='bx bx-envelope me-1'></i> {{ __('publications_show.contact') }}
                    </a>
                    @php
                        $isFavorited = Auth::user()->favs->contains($publication->id);
                    @endphp
                    <form action="{{ $isFavorited ? route('publications.unfavorite', $publication->id) : route('publications.favorite', $publication->id) }}" method="POST" class="d-inline flex-grow-1 m-1">
                        @csrf
                        @if ($isFavorited)
                            @method('DELETE')
                            <button type="submit" class="btn btn-favorite w-100">
                                <i class='bx bxs-heart me-1'></i> {{ __('publications_show.unfavorite') }}
                            </button>
                        @else
                            <button type="submit" class="btn btn-favorite w-100">
                                <i class='bx bx-heart me-1'></i> {{ __('publications_show.favorite') }}
                            </button>
                        @endif
                    </form>
                    <button type="button" class="btn btn-report text-light flex-grow-1 m-1" data-bs-toggle="modal" data-id="{{ $publication->id }}" data-bs-target="#reportModal">
                        <i class='bx bx-flag me-1'></i> {{ __('publications_show.report') }}
                    </button>
                    {{-- <a href="{{ route('index') }}" class="btn btn-home flex-grow-1 m-1">
                        <i class="fa-solid fa-house me-1"></i> {{ __('publications_show.home') }}
                    </a> --}}
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column">
                <div class="flex-grow-1 mb-2">
                    <div class="card">
                        <div class="card-body border rounded p-3">
                            <h1 class="mb-3">
                                {{ $publication->name }}
                                @if ($publication->reports->count() > 0 && Auth::user()->role == 'administrador')
                                    <span class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="@foreach ($publication->reports as $report) {{ $report->pivot->reason }}: {{ $report->pivot->additional_info }}&#013; @endforeach">
                                        {{ $publication->reports->count() }} {{ __('publications_show.reports') }}
                                    </span>
                                @endif
                            </h1>
                            <div class="detail-item"><strong>{{ __('publications_show.author') }}:</strong> {{ $publication->user->username }}</div>
                            <div class="detail-item"><strong>{{ __('publications_show.type') }}:</strong> {{ __('publications_show.type_values.' . $publication->type) }}</div>
                            <div class="detail-item"><strong>{{ __('publications_show.animal_type') }}:</strong> {{ __('publications_show.animal_type_values.' . $publication->type_animal) }}</div>
                            <div class="detail-item"><strong>{{ __('publications_show.size') }}:</strong> {{ __('publications_show.publication_size.' . strtolower($publication->size)) }}</div>
                            <div class="detail-item"><strong>{{ __('publications_show.date') }}:</strong> {{ \Carbon\Carbon::parse($publication->date)->format('d-m-Y') }}</div>
                            <div class="detail-item"><strong>{{ __('publications_show.description') }}:</strong>
                                <span class="text-muted">{{ \Illuminate\Support\Str::limit($publication->description, 40) }}</span>
                                @if (strlen($publication->description) > 40)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#descriptionModal">{{ __('publications_show.read_more') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1 mt-2" id="mi_mapa" style="width: 100%; height: 100%; border-radius: 1rem;"></div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let map = L.map('mi_mapa').setView([{{ $publication->latitude }}, {{ $publication->longitude }}], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);

                L.marker([{{ $publication->latitude }}, {{ $publication->longitude }}]).addTo(map);

                // Inicializar tooltips de Bootstrap
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            });
        </script>
    </div>

    <!-- Modal para la descripción -->
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descriptionModalLabel">{{ __('publications_show.description') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ $publication->description }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('publications_show.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para reportar -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">{{ __('publications_show.report_publication') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm" method="POST" action="{{ route('publications.report', $publication->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="reason" class="form-label">{{ __('publications_show.report_reason') }}</label>
                            <select class="form-select" id="reason" name="reason" required>
                                <option value="Contenido inapropiado">{{ __('publications_show.report_reason_inappropriate') }}</option>
                                <option value="Información incorrecta">{{ __('publications_show.report_reason_incorrect') }}</option>
                                <option value="Spam">{{ __('publications_show.report_reason_spam') }}</option>
                                <option value="Otra razón">{{ __('publications_show.report_reason_other') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="additional_info" class="form-label">{{ __('publications_show.additional_info') }}</label>
                            <textarea class="form-control" id="additional_info" name="additional_info" rows="3" maxlength="200"></textarea>
                        </div>
                        <button type="submit" class="btn btn-report">{{ __('publications_show.send_report') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
