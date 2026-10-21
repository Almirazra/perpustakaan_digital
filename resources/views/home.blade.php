@extends('layouts.app')

<<<<<<< Updated upstream
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Selamat datang, {{ Auth::user()->name }}</li>
    </ol>

    {{-- Ringkasan --}}
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="small">Total buku</div>
                    <div class="fs-2 fw-bold">{{ $totalBuku }}</div>
                </div>
                <div class="card-footer"><a class="small text-white stretched-link" href="{{ route('buku.index') }}">Lihat data</a></div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="small">Total siswa</div>
                    <div class="fs-2 fw-bold">{{ $totalSiswa }}</div>
                </div>
                <div class="card-footer"><a class="small text-white stretched-link" href="{{ route('siswa.index') }}">Lihat data</a></div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-dark mb-4">
                <div class="card-body">
                    <div class="small">Sedang dipinjam</div>
                    <div class="fs-2 fw-bold">{{ $sedangDipinjam }}</div>
                </div>
                <div class="card-footer"><a class="small text-dark stretched-link" href="{{ route('peminjaman.index') }}">Lihat data</a></div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="small">Denda belum dibayar</div>
                    <div class="fs-2 fw-bold">Rp{{ number_format($dendaBelumBayar, 0, ',', '.') }}</div>
                </div>
                <div class="card-footer"><a class="small text-white stretched-link" href="{{ route('denda.index') }}">Lihat data</a></div>
=======
@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Judul Halaman -->
    <h1 class="mt-2 mb-4">Dashboard Siswa</h1>

    <!-- 3 Kartu Ringkasan Atas (Kondisi Awal Kosong / 0) -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border border-dark rounded-0 h-100">
                <div class="card-body">
                    <span class="text-muted small">Sedang Dipinjam</span>
                    <h3 class="fw-bold mt-2 mb-0">{{ $totalDipinjam ?? '0' }} buku</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border border-dark rounded-0 h-100">
                <div class="card-body">
                    <span class="text-muted small">Jatuh Tempo Terdekat</span>
                    <h3 class="fw-bold mt-2 mb-0">{{ $jatuhTempoTerdekat ?? '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border border-dark rounded-0 h-100">
                <div class="card-body">
                    <span class="text-muted small">Total Denda</span>
                    <h3 class="fw-bold mt-2 mb-0">Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</h3>
                </div>
>>>>>>> Stashed changes
            </div>
        </div>
    </div>

<<<<<<< Updated upstream
        {{-- Baris 1: grafik + aktivitas terbaru (admin) --}}
    @php $admin = Auth::user()->role === 'admin'; @endphp
    <div class="row g-3 mb-4">
        <div class="col-xl-{{ $admin ? 8 : 12 }}">
            <div class="card h-100">
                <div class="card-header"><i class="fas fa-chart-column me-1"></i> Grafik peminjaman per bulan</div>
                <div class="card-body">
                    <div style="position:relative;height:300px">
                        <canvas id="grafikBulanan"></canvas>
=======
    <!-- Bagian Bawah: Tabel Peminjaman Aktif & Notifikasi -->
    <div class="row g-3">
        <!-- Tabel Peminjaman Aktif (Kiri) -->
        <div class="col-lg-8">
            <div class="card shadow-sm border border-dark rounded-0 h-100">
                <div class="card-header bg-white border-bottom border-dark py-3">
                    <h5 class="fw-bold mb-0">Peminjaman Aktif</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" style="border-color: #000;">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peminjamanAktif ?? [] as $item)
                                    <tr>
                                        <td>{{ $item->buku->judul }}</td>
                                        <td>{{ $item->tanggal_peminjaman->format('d M Y') }}</td>
                                        <td>{{ $item->tanggal_kembali->format('d M Y') }}</td>
                                        <td>{{ ucfirst($item->status) }}</td>
                                        <td>Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <!-- Tampilan jika siswa belum meminjam buku sama sekali -->
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Belum ada buku yang sedang dipinjam. Yuk, pinjam buku di menu <strong>Buku</strong>!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
>>>>>>> Stashed changes
                    </div>
                </div>
            </div>
        </div>

<<<<<<< Updated upstream
        @if ($admin)
            <div class="col-xl-4">
                <div class="card h-100 d-flex flex-column">
                    <div class="card-header"><i class="fas fa-clock-rotate-left me-1"></i> Aktivitas terbaru</div>
                    <ul class="list-group list-group-flush flex-grow-1 overflow-auto" style="max-height:356px">
                        @forelse ($aktivitas as $a)
                            @php
                                $ikon = ['login' => 'fa-right-to-bracket', 'tambah' => 'fa-plus', 'ubah' => 'fa-pen', 'hapus' => 'fa-trash'][$a->aksi] ?? 'fa-circle';
                            @endphp
                            <li class="list-group-item d-flex align-items-start">
                                <i class="fas {{ $ikon }} fa-fw mt-1 me-2 text-secondary"></i>
                                <div class="flex-grow-1">
                                    <div class="small">{{ $a->deskripsi }}</div>
                                    <div class="text-muted" style="font-size:.75rem">
                                        {{ $a->user->name ?? 'Sistem' }} &middot; {{ $a->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center">Belum ada aktivitas tercatat.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endif
    </div>

    {{-- Baris 2: denda belum dibayar + transaksi terbaru --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-coins me-1"></i> Denda belum dibayar</span>
                    <a href="{{ route('denda.index', ['status' => 'belum_bayar']) }}" class="small">Lihat semua</a>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($daftarDenda as $d)
                        @php $p = $d->pengembalian->peminjaman; @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center gap-2">
                            <span>
                                {{ $p->siswa->nama_lengkap }}
                                <span class="text-muted">- {{ Str::limit($p->buku->judul, 22) }}</span>
                            </span>
                            <strong class="text-nowrap">Rp{{ number_format($d->jumlah, 0, ',', '.') }}</strong>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Tidak ada denda yang belum dibayar.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-table me-1"></i> Transaksi terbaru</span>
                    <a href="{{ route('peminjaman.index') }}" class="small">Lihat semua</a>
                </div>
                <div class="card-body">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr><th style="width:40px">No</th><th>Anggota</th><th>Judul buku</th><th>Tgl pinjam</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksiTerbaru as $t)
                                @php
                                    if ($t->status === 'dikembalikan') {
                                        $label = 'Dikembalikan'; $kelas = 'bg-success';
                                    } elseif ($t->tanggal_kembali->lt(today())) {
                                        $label = 'Terlambat'; $kelas = 'bg-danger';
                                    } else {
                                        $label = 'Dipinjam'; $kelas = 'bg-warning text-dark';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $t->siswa->nama_lengkap }}</td>
                                    <td>{{ $t->buku->judul }}</td>
                                    <td>{{ $t->tanggal_peminjaman->format('d M Y') }}</td>
                                    <td><span class="badge {{ $kelas }}">{{ $label }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
=======
        <!-- Kolom Notifikasi (Kanan) -->
        <div class="col-lg-4">
            <div class="card shadow-sm border border-dark rounded-0 h-100">
                <div class="card-header bg-white border-bottom border-dark py-3">
                    <h5 class="fw-bold mb-0">Notifikasi</h5>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    <div class="border border-dark p-3 bg-light">
                        <h6 class="fw-bold mb-1">Selamat Datang!</h6>
                        <p class="mb-0 text-muted small">Akun siswa berhasil masuk. Silakan pilih menu Buku untuk mulai meminjam.</p>
                    </div>
>>>>>>> Stashed changes
                </div>
            </div>
        </div>
    </div>
<<<<<<< Updated upstream
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const bulanan = @json($grafikBulanan);

new Chart(document.getElementById('grafikBulanan'), {
    type: 'bar',
    data: {
        labels: bulanan.labels,
        datasets: [{
            label: 'Peminjaman',
            data: bulanan.data,
            backgroundColor: '#3E4A56',
            borderRadius: 4,
        }],
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
    },
});
</script>
@endpush
=======
</div>
@endsection
>>>>>>> Stashed changes
