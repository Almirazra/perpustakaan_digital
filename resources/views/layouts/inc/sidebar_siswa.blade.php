<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu Siswa</div>

            <!-- Dashboard -->
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <a class="nav-link {{ request()->routeIs('siswa.buku*') ? 'active' : '' }}" href="{{ route('siswa.buku.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                Buku
            </a>

            <!-- Peminjaman Aktif -->
            <a class="nav-link {{ request()->routeIs('siswa.peminjaman*') ? 'active' : '' }}" href="{{ route('siswa.peminjaman.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-hand-holding"></i></div>
                Peminjaman
            </a>

            <!-- Riwayat -->
            <a class="nav-link {{ request()->routeIs('siswa.riwayat*') ? 'active' : '' }}" href="{{ route('siswa.riwayat.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                Riwayat
            </a>

            <div class="sb-sidenav-menu-heading">Akun</div>

            <!-- Keluar / Logout -->
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <div class="sb-sidenav-footer">
    </div>
</nav>