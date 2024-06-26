@extends('layout')

@section('title', __('texts_index.title'))

@section('content')
    <div class="container-fluid mt-4 px-5">
        <h2 class="mb-4">{{ __('texts_index.header') }}</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">{{ __('texts_index.from') }}</th>
                        <th class="ps-3">{{ __('texts_index.phone') }}</th>
                        <th class="ps-3">{{ __('texts_index.subject') }}
                            <div class="float-end">
                                <a href="{{ route('texts.index', ['subject_sort' => $subjectSort === 'asc' ? 'desc' : 'asc']) }}"
                                    class="btn btn-sm btn-link p-0 mx-2">
                                    <i class="fas fa-sort text-lightgreen"></i>
                                </a>
                            </div>
                        </th>
                        <th class="ps-3">{{ __('texts_index.short_description') }}</th>
                        <th class="ps-3">
                            {{ __('texts_index.date') }}
                            <div class="float-end">
                                <a href="{{ route('texts.index', ['sort' => $sort === 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-sm btn-link p-0 mx-2">
                                    <i class="fas fa-sort text-lightgreen"></i>
                                </a>
                            </div>
                        </th>
                        <th class="text-center justify-content-center">{{ __('texts_index.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                        <tr id="message-{{ $message->id }}" class="{{ $message->is_read ? 'table-warning' : '' }}">
                            <td class="ps-3">{{ $message->sender->username }}</td>
                            <td class="ps-3">{{ $message->sender->phone }}</td>
                            <td class="text-truncate ps-3" style="max-width: 100%;">
                                {{ Str::limit($message->subject, 30) }}
                                @if (strlen($message->subject) > 30)
                                    <button type="button" class="btn btn-link p-0 m-0 align-baseline text-darkgreen"
                                        style="display: inline;" data-bs-toggle="modal" data-bs-target="#subjectModal"
                                        data-subject="{{ $message->subject }}">
                                        {{ __('texts_index.read_more') }}
                                    </button>
                                @endif
                            </td>
                            <td class="text-truncate ps-3" style="max-width: 100%;">
                                {{ Str::limit($message->short_description, 30) }}
                                @if (strlen($message->short_description) > 30)
                                    <button type="button" class="btn btn-link p-0 m-0 align-baseline"
                                        style="display: inline;" data-bs-toggle="modal" data-bs-target="#descriptionModal"
                                        data-description="{{ $message->short_description }}">
                                        {{ __('texts_index.read_more') }}
                                    </button>
                                @endif
                            </td>
                            <td class="text-nowrap ps-3">{{ $message->created_at->format('d-m-Y H:i') }}</td>
                            <td class="text-center d-flex justify-content-center gap-1 flex-wrap">
                                <button type="button" class="btn btn-sm btn-danger flex-grow-1" data-bs-toggle="modal"
                                    data-bs-target="#deleteMessageModal" data-message-id="{{ $message->id }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary flex-grow-1"
                                    onclick="toggleRead({{ $message->id }})">
                                    <i class="fas fa-eye{{ $message->is_read ? '-slash' : '' }}"
                                        id="icon-{{ $message->id }}"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary flex-grow-1" data-bs-toggle="modal"
                                    data-bs-target="#replyMessageModal" data-emitter-id="{{ $message->emitter_id }}"
                                    data-subject="{{ $message->subject }}">
                                    <i class="fas fa-reply"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-1 mb-2">
            <div>
                {{ $messages->links() }}
            </div>
            <div class="ms-auto d-flex gap-2">
                <a class="btn btn-secondary" href="{{ route('index') }}">
                    <i class="fas fa-arrow-left me-2"></i> {{ __('texts_index.back_to_home') }}
                </a>
                <a class="btn btn-success" href="{{ route('texts.export') }}">
                    <i class="fas fa-file-excel me-2"></i> {{ __('texts_index.export') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación para Eliminar Mensaje -->
    <div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="deleteMessageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMessageModalLabel">{{ __('texts_index.confirm_delete') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('texts_index.confirm_delete_body') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('texts_index.cancel') }}</button>
                    <form id="deleteMessageForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('texts_index.confirm') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Mostrar Asunto Completo -->
    <div class="modal fade" id="subjectModal" tabindex="-1" aria-labelledby="subjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subjectModalLabel">{{ __('texts_index.full_subject') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="fullSubject" class="text-wrap" style="white-space: pre-wrap; word-break: break-word;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('texts_index.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Mostrar Descripción Completa -->
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descriptionModalLabel">{{ __('texts_index.full_description') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="fullDescription" class="text-wrap" style="white-space: pre-wrap; word-break: break-word;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('texts_index.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Responder Mensaje -->
    <div class="modal fade" id="replyMessageModal" tabindex="-1" aria-labelledby="replyMessageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyMessageModalLabel">{{ __('texts_index.reply_message') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="replyMessageForm" method="POST" action="{{ route('texts.store') }}">
                        @csrf
                        <input type="hidden" name="receiver_id" id="replyReceiverId">
                        <div class="mb-3">
                            <label for="replySubject" class="form-label">{{ __('texts_index.subject') }}</label>
                            <input type="text" class="form-control" id="replySubject" name="subject" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="replyDescription" class="form-label">{{ __('texts_index.message') }}</label>
                            <textarea class="form-control" id="replyDescription" name="short_description" rows="4" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('texts_index.close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('texts_index.send') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script para modal de eliminación
            let deleteMessageModal = document.getElementById('deleteMessageModal');
            deleteMessageModal.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;
                let messageId = button.getAttribute('data-message-id');
                let deleteMessageForm = document.getElementById('deleteMessageForm');
                deleteMessageForm.action = '/texts/' + messageId;
            });

            // Script para modal de asunto
            let subjectModal = document.getElementById('subjectModal');
            subjectModal.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;
                let subject = button.getAttribute('data-subject');
                let fullSubject = document.getElementById('fullSubject');
                fullSubject.textContent = subject;
            });

            // Script para modal de descripción
            let descriptionModal = document.getElementById('descriptionModal');
            descriptionModal.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;
                let description = button.getAttribute('data-description');
                let fullDescription = document.getElementById('fullDescription');
                fullDescription.textContent = description;
            });

            // Script para modal de respuesta
            let replyMessageModal = document.getElementById('replyMessageModal');
            replyMessageModal.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;
                let emitterId = button.getAttribute('data-emitter-id');
                let subject = button.getAttribute('data-subject');
                let replyReceiverId = document.getElementById('replyReceiverId');
                let replySubject = document.getElementById('replySubject');

                replyReceiverId.value = emitterId;
                replySubject.value = subject;
            });
        });

        function toggleRead(messageId) {
            let row = document.getElementById('message-' + messageId);
            if (row) {
                row.classList.toggle('table-warning');
                let isRead = row.classList.contains('table-warning');
                setIcon(messageId, isRead);

                // Actualizar estado en el backend
                fetch(`/texts/${messageId}/toggle-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => response.json()).then(data => {
                    if (!data.success) {
                        // Revertir cambios si hay error
                        row.classList.toggle('table-warning');
                        setIcon(messageId, !isRead);
                    }
                });
            }
        }

        function setIcon(messageId, isRead) {
            let icon = document.getElementById('icon-' + messageId);
            if (isRead) {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
