<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="{{ url('/home') }}">Perpustakaan</a>

    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" type="button">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="navbar-nav ms-auto me-3 me-lg-4">
        @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="menuUser" href="#" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuUser">
                    <li><span class="dropdown-item-text small text-muted">Peran: {{ Auth::user()->role }}</span></li>
                    <li><hr class="dropdown-divider" /></li>
                    @if (Route::has('logout'))
                        <li>
                            <a class="dropdown-item" href="#"
                               onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
                                Logout
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endauth
    </ul>

    @if (Route::has('logout'))
        <form id="form-logout" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    @endif
</nav>
