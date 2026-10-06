<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            @auth
        <div class="sb-sidenav-footer">
            <div class="small">Masuk sebagai:</div>
            {{ Auth::user()->name }}
            <div class="small text-white-50">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
    @endauth


            <div class="sb-sidenav-menu-heading">Utama</div>
            <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ url('/home') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <div class="sb-sidenav-menu-heading">Data Master</div>
            <a class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}" href="{{ url('/kategori') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                Kategori
            </a>
            <a class="nav-link {{ request()->is('buku*') ? 'active' : '' }}" href="{{ url('/buku') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                Buku
            </a>
            <a class="nav-link {{ request()->is('siswa*') ? 'active' : '' }}" href="{{ url('/siswa') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                Siswa
            </a>

            <div class="sb-sidenav-menu-heading">Transaksi</div>
            <a class="nav-link {{ request()->is('peminjaman*') ? 'active' : '' }}" href="{{ url('/peminjaman') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-hand-holding"></i></div>
                Peminjaman
            </a>
            <a class="nav-link {{ request()->is('pengembalian*') ? 'active' : '' }}" href="{{ url('/pengembalian') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-rotate-left"></i></div>
                Pengembalian
            </a>
            <a class="nav-link {{ request()->is('denda*') ? 'active' : '' }}" href="{{ url('/denda') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-coins"></i></div>
                Denda
            </a>
            <a class="nav-link {{ request()->is('notifikasi*') ? 'active' : '' }}" href="{{ url('/notifikasi') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                Notifikasi
            </a>

        </div>
    </div>
</nav>
