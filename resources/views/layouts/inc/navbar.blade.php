<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Brand / Logo -->
    <a class="navbar-brand ps-3" href="{{ url('/home') }}">Perpustakaan</a>

    <!-- Tombol Toggle Sidebar -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" type="button">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Bagian Kanan Navbar -->
    <ul class="navbar-nav ms-auto me-3 me-lg-4 align-items-center">
        @auth
            <!-- Teks Sapaan dan Ikon Khusus Siswa -->
            @if(Auth::user()->role === 'siswa')
                <!-- Teks Sapaan -->
                <li class="nav-item me-3 text-white small d-none d-md-inline">
                    Halo, {{ Auth::user()->name }}
                </li>

                <!-- Ikon Amplop Pesan -->
                <li class="nav-item me-3">
                    <a href="{{ route('siswa.notifikasi.index') }}" class="nav-link text-white position-relative px-2" title="Pesan Masuk">
                        <i class="fas fa-envelope fa-lg"></i>
                        @if(isset($jumlahBelum) && $jumlahBelum > 0)
                            <span class="position-absolute top-25 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.55rem;">
                                {{ $jumlahBelum }}
                            </span>
                        @endif
                    </a>
                </li>
            @endif

            <!-- Menu Dropdown Profil User -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="menuUser" href="#" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-lg"></i>
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

    <!-- Form Logout -->
    @if (Route::has('logout'))
        <form id="form-logout" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    @endif
</nav>