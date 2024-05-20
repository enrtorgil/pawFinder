<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index') }}">
            PawFinder
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav w-100">
                @if (Auth::check() && Auth::user()->role == 'administrador')
                    <li class="nav-item dropdown mx-4">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.users') }}">Usuarios</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.publications') }}">Publicaciones</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.reports') }}">Reportes</a></li>
                        </ul>
                    </li>
                @endif

                @if (Auth::check())
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="{{ route('publications.index') }}">Publicaciones</a>
                    </li>
                    <li class="nav-item dropdown mx-4">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Mi espacio
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}">Mi
                                    Perfil</a></li>
                            <li><a class="dropdown-item" href="{{ route('publications.my') }}">Mis anuncios</a></li>
                            <li><a class="dropdown-item" href="{{ route('favs.index') }}">Favoritos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="{{ route('texts.index') }}">
                            Mensajes <span id="unread-count" class="badge bg-danger" style="display:none;">0</span>
                        </a>
                    </li>
                @endif

                @if (!Auth::check())
                    @if (Route::currentRouteName() !== 'index')
                        <li class="nav-item mx-4">
                            <a class="nav-link" href="{{ route('index') }}">Iniciar sesión</a>
                        </li>
                    @endif
                    @if (Route::currentRouteName() !== 'register')
                        <li class="nav-item mx-4">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endif
                @endif

                <li class="nav-item ms-auto"></li>

                @if (Auth::check())
                    <li class="nav-item mx-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Cerrar sesión</button>
                        </form>
                    </li>
                @endif
                <li class="nav-item mx-4">
                    <a class="nav-link" href="#">
                        <i class='bx bx-globe'></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
