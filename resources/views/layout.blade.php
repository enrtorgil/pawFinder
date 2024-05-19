<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
</head>

<body>
    @include('partials.nav')
    @yield('content')
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        function fetchUnreadCount() {
            $.ajax({
                url: '{{ route('messages.unreadCount') }}',
                method: 'GET',
                success: function(data) {
                    let unreadCount = document.getElementById('unread-count');
                    unreadCount.innerText = data.unread_count;
                    if (data.unread_count > 0) {
                        unreadCount.style.display = 'inline';
                    } else {
                        unreadCount.style.display = 'none';
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchUnreadCount();
            setInterval(fetchUnreadCount, 5000); // Polling cada 5 segundos
        });

        function toggleRead(messageId) {
            $.ajax({
                url: '{{ url('/texts') }}/' + messageId + '/toggle-read',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.success) {
                        var row = document.getElementById('message-' + messageId);
                        if (row) {
                            row.classList.toggle('table-warning');
                            var icon = document.getElementById('icon-' + messageId);
                            if (row.classList.contains('table-warning')) {
                                icon.classList.remove('fa-eye');
                                icon.classList.add('fa-eye-slash');
                            } else {
                                icon.classList.remove('fa-eye-slash');
                                icon.classList.add('fa-eye');
                            }
                            fetchUnreadCount();
                        }
                    }
                }
            });
        }
    </script>
</body>

</html>
