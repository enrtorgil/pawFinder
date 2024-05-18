@extends('layout')

@section('content')
    <div class="container mt-3">
        <h2>Mensajes Recibidos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>De</th>
                    <th>Asunto</th>
                    <th>Descripción breve</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                    <tr id="message-{{ $message->id }}">
                        <td>{{ $message->sender->username }}</td>
                        <td>{{ $message->subject }}</td>
                        <td>
                            {{ Str::limit($message->short_description, 50) }}
                            @if (strlen($message->short_description) > 50)
                                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal"
                                    data-bs-target="#descriptionModal" data-description="{{ $message->short_description }}">
                                    Leer más
                                </button>
                            @endif
                        </td>
                        <td>{{ $message->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteMessageModal" data-message-id="{{ $message->id }}">Eliminar</button>
                            <button type="button" class="btn btn-sm btn-secondary"
                                onclick="toggleRead({{ $message->id }})">
                                <i class="fas" id="icon-{{ $message->id }}"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#replyMessageModal" data-emitter-id="{{ $message->emitter_id }}"
                                data-subject="Re: {{ $message->subject }}">
                                <i class="fas fa-reply"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal de Confirmación para Eliminar Mensaje -->
    <div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="deleteMessageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMessageModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este mensaje?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteMessageForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Mostrar Descripción Completa -->
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descriptionModalLabel">Descripción completa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="fullDescription" class="text-wrap" style="white-space: pre-wrap; word-break: break-word;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                    <h5 class="modal-title" id="replyMessageModalLabel">Responder Mensaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="replyMessageForm" method="POST" action="{{ route('texts.store') }}">
                        @csrf
                        <input type="hidden" name="receiver_id" id="replyReceiverId">
                        <div class="mb-3">
                            <label for="replySubject" class="form-label">Asunto</label>
                            <input type="text" class="form-control" id="replySubject" name="subject" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="replyDescription" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="replyDescription" name="short_description" rows="4" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteMessageModal = document.getElementById('deleteMessageModal');
            var deleteMessageForm = document.getElementById('deleteMessageForm');

            deleteMessageModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var messageId = button.getAttribute('data-message-id');
                deleteMessageForm.action = '/texts/' + messageId;
            });

            var descriptionModal = document.getElementById('descriptionModal');
            descriptionModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var description = button.getAttribute('data-description');
                var fullDescription = document.getElementById('fullDescription');
                fullDescription.textContent = description;
            });

            var replyMessageModal = document.getElementById('replyMessageModal');
            replyMessageModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var emitterId = button.getAttribute('data-emitter-id');
                var subject = button.getAttribute('data-subject');
                var replyReceiverId = document.getElementById('replyReceiverId');
                var replySubject = document.getElementById('replySubject');

                replyReceiverId.value = emitterId;
                replySubject.value = subject;
            });

            // Initialize icons based on read status
            @foreach ($messages as $message)
                setIcon({{ $message->id }}, false); // Inicializa con no leído
            @endforeach
        });

        function toggleRead(messageId) {
            var row = document.getElementById('message-' + messageId);
            if (row) {
                row.classList.toggle('table-warning'); // Use Bootstrap class for color change
                var isRead = row.classList.contains('table-warning');
                setIcon(messageId, isRead);
            }
        }

        function setIcon(messageId, isRead) {
            var icon = document.getElementById('icon-' + messageId);
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
