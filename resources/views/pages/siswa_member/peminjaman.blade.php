@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h1 class="h3 mb-0 text-dark fw-bold">Peminjaman Aktif Saya</h1>
            <p class="text-muted small mb-0">Daftar buku yang sedang kamu pinjam saat ini.</p>
        </div>
        <a href="{{ route('siswa.buku.index') }}" class="btn btn-dark btn-sm">
            <i class="fas fa-plus me-1"></i> Pinjam Buku Lain
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Ringkasan Statistik Atas -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #343a40 !important;">
                <div class="card-body">
                    <div class="text-muted small fw-semibold text-uppercase">Buku Sedang Dipinjam</div>
                    <div class="h3 fw-bold text-dark mt-1 mb-0">{{ $peminjamans->sum('jumlah') }} <span class="fs-6 fw-normal text-muted">Eksemplar</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd !important;">
                <div class="card-body">
                    <div class="text-muted small fw-semibold text-uppercase">Jatuh Tempo Terdekat</div>
                    <div class="h4 fw-bold text-dark mt-1 mb-0">
                        {{ $jatuhTempoTerdekat ? $jatuhTempoTerdekat->format('d M Y') : '-' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @php
                $warnaBorder = $totalDenda > 0 ? '#dc3545' : '#198754';
            @endphp
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid {{ $warnaBorder }} !important;">
                <div class="card-body">
                    <div class="text-muted small fw-semibold text-uppercase">Estimasi Denda Berjalan</div>
                    <div class="h3 fw-bold {{ $totalDenda > 0 ? 'text-danger' : 'text-success' }} mt-1 mb-0">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Peminjaman Aktif -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
            <span class="fw-semibold"><i class="fas fa-book-reader me-2"></i>Daftar Peminjaman Berlangsung</span>
            <span class="badge bg-secondary">{{ $peminjamans->count() }} Transaksi</span>
        </div>
        <div class="card-body p-0">
            @if($peminjamans->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                    <h5 class="fw-bold text-dark">Belum Ada Peminjaman Aktif</h5>
                    <p class="text-muted small mb-3">Kamu sedang tidak meminjam buku apa pun saat ini.</p>
                    <a href="{{ route('siswa.buku.index') }}" class="btn btn-dark btn-sm px-4">Jelajahi Katalog Buku</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Buku</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Batas Kembali</th>
                                <th>Status</th>
                                <th>Denda</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamans as $pinjam)
                                @php
                                    $isTerlambat = now()->startOfDay()->gt($pinjam->tanggal_kembali->startOfDay());
                                    $sisaHari = now()->startOfDay()->diffInDays($pinjam->tanggal_kembali->startOfDay(), false);
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($pinjam->buku && $pinjam->buku->cover)
                                                <img src="{{ asset('assets/img/' . $pinjam->buku->cover) }}" alt="Cover" class="rounded me-3 border" style="width: 45px; height: 60px; object-fit: contain;">
                                            @else
                                                <div class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center me-3 text-muted small" style="width: 45px; height: 60px;">
                                                    Cover
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $pinjam->buku->judul ?? 'Judul Tidak Tersedia' }}</div>
                                                <div class="text-muted small">
                                                    {{ $pinjam->buku->pengarang ?? '-' }} • 
                                                    <span class="badge bg-light text-dark border">{{ $pinjam->buku->kategori->nama_kategori ?? 'Umum' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="fw-semibold">{{ $pinjam->jumlah }}</span> eks</td>
                                    <td>{{ $pinjam->tanggal_peminjaman->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="fw-semibold {{ $isTerlambat ? 'text-danger' : 'text-dark' }}">
                                            {{ $pinjam->tanggal_kembali->format('d/m/Y') }}
                                        </div>
                                        @if($isTerlambat)
                                            <small class="text-danger">Terlambat {{ abs($sisaHari) }} hari</small>
                                        @elseif($sisaHari == 0)
                                            <small class="text-warning fw-bold">Jatuh tempo hari ini</small>
                                        @else
                                            <small class="text-muted">Sisa {{ $sisaHari }} hari</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($isTerlambat)
                                            <span class="badge bg-danger">Terlambat</span>
                                        @elseif($sisaHari <= 2)
                                            <span class="badge bg-warning text-dark">Segera Kembali</span>
                                        @else
                                            <span class="badge bg-primary">Dipinjam</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pinjam->estimasi_denda > 0)
                                            <span class="text-danger fw-bold">Rp {{ number_format($pinjam->estimasi_denda, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">Rp 0</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pinjam->id }}">
                                            Detail
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Detail Peminjaman -->
                                <div class="modal fade" id="detailModal{{ $pinjam->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-dark text-white">
                                                <h5 class="modal-title fs-6">Rincian Peminjaman #{{ $pinjam->id }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6 class="fw-bold text-dark mb-1">{{ $pinjam->buku->judul ?? '-' }}</h6>
                                                <p class="text-muted small mb-3">Pengarang: {{ $pinjam->buku->pengarang ?? '-' }} | Penerbit: {{ $pinjam->buku->penerbit ?? '-' }}</p>
                                                <ul class="list-group list-group-flush small">
                                                    <li class="list-group-item d-flex justify-content-between px-0">
                                                        <span class="text-muted">Tanggal Pinjam</span>
                                                        <span class="fw-semibold">{{ $pinjam->tanggal_peminjaman->format('d F Y') }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between px-0">
                                                        <span class="text-muted">Batas Pengembalian</span>
                                                        <span class="fw-semibold">{{ $pinjam->tanggal_kembali->format('d F Y') }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between px-0">
                                                        <span class="text-muted">Jumlah Dipinjam</span>
                                                        <span class="fw-semibold">{{ $pinjam->jumlah }} Eksemplar</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between px-0">
                                                        <span class="text-muted">Estimasi Denda</span>
                                                        <span class="fw-bold {{ $pinjam->estimasi_denda > 0 ? 'text-danger' : 'text-success' }}">
                                                            Rp {{ number_format($pinjam->estimasi_denda, 0, ',', '.') }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Ketentuan Peminjaman -->
    <div class="card border-0 shadow-sm bg-light">
        <div class="card-body py-3">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle text-dark mt-1 me-3"></i>
                <div class="small text-muted">
                    <strong class="text-dark">Ketentuan Peminjaman:</strong> Harap kembalikan buku ke petugas perpustakaan sebelum melewati tanggal batas kembali untuk menghindari denda keterlambatan sebesar <strong>Rp 1.000/hari</strong> per buku.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection