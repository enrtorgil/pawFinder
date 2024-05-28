<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index') }}">
            <img src="{{ asset('img/logo-pawfinder.png') }}" alt="PawFinder Logo"  class="logo-img">
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
                            <i class='bx bx-cog d-lg-none'></i> Admin
                        </a>
                        <ul class="dropdown-menu border-1 p-0" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center"
                                    href="{{ route('admin.users') }}"><i class='bx bx-user d-lg-none me-2'></i>
                                    Usuarios</a></li>
                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center"
                                    href="{{ route('admin.publications') }}"><i class='bx bx-book d-lg-none me-2'></i>
                                    Publicaciones</a></li>
                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center"
                                    href="{{ route('admin.reports') }}"><i class='bx bx-flag d-lg-none me-2'></i>
                                    Reportes</a></li>
                        </ul>
                    </li>
                @endif

                @if (Auth::check())
                    <li class="nav-item mx-4">
                        <a class="nav-link d-flex align-items-center" href="{{ route('publications.index') }}"><i
                                class='bx bx-book d-lg-none me-2'></i> Publicaciones</a>
                    </li>
                    <li class="nav-item dropdown mx-4">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-user-circle d-lg-none me-2'></i> Mi espacio
                        </a>
                        <ul class="dropdown-menu border-1 p-0" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center"
                                    href="{{ route('users.edit', Auth::user()->id) }}"><i
                                        class='bx bx-user d-lg-none me-2'></i> Mi perfil</a></li>
                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center"
                                    href="{{ route('publications.my') }}"><i class='bx bx-book d-lg-none me-2'></i> Mis
                                    anuncios</a></li>
                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center"
                                    href="{{ route('favs.index') }}"><i class='bx bx-heart d-lg-none me-2'></i>
                                    Favoritos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link d-flex align-items-center" href="{{ route('texts.index') }}">
                            <i class='bx bx-envelope d-lg-none me-2'></i>
                            Mensajes <span id="unread-count" class="badge bg-danger ms-2 unread-count">0</span>
                        </a>
                    </li>
                @endif

                @if (!Auth::check())
                    @if (Route::currentRouteName() !== 'index')
                        <li class="nav-item mx-4">
                            <a class="nav-link d-flex align-items-center" href="{{ route('index') }}"><i
                                    class='bx bx-log-in d-lg-none me-2'></i> Iniciar sesión</a>
                        </li>
                    @endif
                    @if (Route::currentRouteName() !== 'register')
                        <li class="nav-item mx-4">
                            <a class="nav-link d-flex align-items-center" href="{{ route('register') }}"><i
                                    class='bx bx-user-plus d-lg-none me-2'></i> Registrarse</a>
                        </li>
                    @endif
                @endif

                <li class="nav-item ms-auto"></li>

                @if (Auth::check())
                    <li class="nav-item mx-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link d-flex align-items-center"><i
                                    class='bx bx-log-out d-lg-none me-2'></i> Cerrar sesión</button>
                        </form>
                    </li>
                @endif
                <li class="nav-item mx-4">
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class='bx bx-globe'></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
