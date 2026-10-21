@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Header Title -->
    <h2 class="fw-bold mb-4">Dashboard Siswa</h2>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border border-dark rounded-3">
                <div class="card-body">
                    <span class="text-muted small fw-semibold">Sedang Dipinjam</span>
                    <h2 class="fw-bold mt-2 mb-0">{{ $totalDipinjam ?? '2' }} buku</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border border-dark rounded-3">
                <div class="card-body">
                    <span class="text-muted small fw-semibold">Jatuh Tempo Terdekat</span>
                    <h2 class="fw-bold mt-2 mb-0">{{ $jatuhTempoTerdekat ?? '12 Okt 2026' }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border border-dark rounded-3">
                <div class="card-body">
                    <span class="text-muted small fw-semibold">Total Denda</span>
                    <h2 class="fw-bold mt-2 mb-0">Rp {{ number_format($totalDenda ?? 5000, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area: Table & Notifications -->
    <div class="row g-3">
        <!-- Table Peminjaman Aktif -->
        <div class="col-lg-8">
            <div class="card shadow-sm border border-dark rounded-3 h-100">
                <div class="card-header bg-white border-bottom border-dark py-3">
                    <h5 class="fw-bold mb-0">Peminjaman Aktif</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" style="border-color: #000;">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold">Judul Buku</th>
                                    <th class="fw-bold">Tgl Pinjam</th>
                                    <th class="fw-bold">Jatuh Tempo</th>
                                    <th class="fw-bold">Status</th>
                                    <th class="fw-bold">Denda</th>
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
                                    <!-- Static Dummy Data Sesuai Wireframe -->
                                    <tr>
                                        <td>Laskar Pelangi</td>
                                        <td>01 Okt 2026</td>
                                        <td>08 Okt 2026</td>
                                        <td>Dipinjam</td>
                                        <td>Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td>Bumi</td>
                                        <td>28 Sep 2026</td>
                                        <td>05 Okt 2026</td>
                                        <td>Terlambat</td>
                                        <td>Rp 5.000</td>
                                    </tr>
                                    <tr>
                                        <td>Matematika X</td>
                                        <td>03 Okt 2026</td>
                                        <td>10 Okt 2026</td>
                                        <td>Dipinjam</td>
                                        <td>Rp 0</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Notifikasi -->
        <div class="col-lg-4">
            <div class="card shadow-sm border border-dark rounded-3">
                <div class="card-header bg-white border-bottom border-dark py-3">
                    <h5 class="fw-bold mb-0">Notifikasi</h5>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    <!-- List Notifikasi -->
                    <div class="border border-dark rounded p-3">
                        <h6 class="fw-bold mb-1">Pengingat jatuh tempo</h6>
                        <p class="mb-0 text-muted small">Buku "Laskar Pelangi" 2 hari lagi</p>
                    </div>

                    <div class="border border-dark rounded p-3">
                        <h6 class="fw-bold mb-1">Denda terbit</h6>
                        <p class="mb-0 text-muted small">Buku "Bumi" terlambat 1 hari</p>
                    </div>

                    <div class="border border-dark rounded p-3">
                        <h6 class="fw-bold mb-1">Peminjaman berhasil</h6>
                        <p class="mb-0 text-muted small">Buku "Matematika X"</p>
                    </div>

                    <div class="border border-dark rounded p-3">
                        <h6 class="fw-bold mb-1">Pengembalian dikonfirmasi</h6>
                        <p class="mb-0 text-muted small">Buku "Dilan 1990"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection