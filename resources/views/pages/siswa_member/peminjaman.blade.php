@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h1 class="h3 mb-0 text-dark fw-bold">Peminjaman Aktif</h1>
            <p class="text-muted small mb-0">Kelola buku yang sedang kamu pinjam dan pantau status buku perpustakaan.</p>
        </div>
        <a href="{{ route('siswa.riwayat.index') }}" class="btn btn-dark btn-sm">
            <i class="fas fa-history me-1"></i> Lihat Riwayat
        </a>
    </div>

    <!-- CARD 1: PEMINJAMAN SAYA -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
            <span class="fw-semibold"><i class="fas fa-book-reader me-2"></i>Buku yang Sedang Kamu Pinjam</span>
            <span class="badge bg-secondary">{{ $peminjamans->count() }} Buku</span>
        </div>
        <div class="card-body p-0">
            @if($peminjamans->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-books fa-3x text-muted mb-3"></i>
                    <h5 class="fw-bold text-dark">Tidak Ada Peminjaman Aktif</h5>
                    <p class="text-muted small mb-3">Kamu sedang tidak meminjam buku apa pun saat ini.</p>
                    <a href="{{ route('siswa.buku.index') }}" class="btn btn-dark btn-sm px-4">Pinjam Buku Sekarang</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Buku</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status / Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamans as $item)
                                @php
                                    $tglJatuhTempo = \Carbon\Carbon::parse($item->tanggal_pengembalian);
                                    $selisihHari = now()->startOfDay()->diffInDays($tglJatuhTempo->startOfDay(), false);
                                    $terlambat = $selisihHari < 0;
                                    $dendaEst = $terlambat ? abs($selisihHari) * 1000 * $item->jumlah : 0;
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($item->buku && $item->buku->cover)
                                                <img src="{{ asset('assets/img/' . $item->buku->cover) }}" alt="Cover" class="rounded me-3 border" style="width: 60px; height: 80px; object-fit: contain;">
                                            @else
                                                <div class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center me-3 text-muted small" style="width: 60px; height: 80px;">Cover</div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $item->buku->judul ?? 'Judul Tidak Tersedia' }}</div>
                                                <div class="text-muted small">{{ $item->buku->pengarang ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="fw-semibold">{{ $item->jumlah }}</span> eks</td>
                                    <td>{{ $item->tanggal_peminjaman ? \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $tglJatuhTempo->format('d/m/Y') }}</td>
                                    <td>
                                        @if($terlambat)
                                            <span class="badge bg-danger mb-1">Terlambat ({{ abs($selisihHari) }} hari)</span>
                                            <div class="text-danger small fw-semibold">Est. Denda: Rp {{ number_format($dendaEst, 0, ',', '.') }}</div>
                                        @elseif($selisihHari <= 2)
                                            <span class="badge bg-warning text-dark mb-1">Segera Kembali ({{ $selisihHari }} hari lagi)</span>
                                            <div class="text-muted small">Tanpa Denda</div>
                                        @else
                                            <span class="badge bg-success mb-1">Dipinjam</span>
                                            <div class="text-muted small">Aman</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- CARD 2: STATUS BUKU SEDANG DIPINJAM SISWA LAIN (TRANSPARANSI) -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-secondary text-white py-3 d-flex justify-content-between align-items-center">
            <span class="fw-semibold"><i class="fas id-card me-2"></i>Status Peminjaman Siswa Lain (Transparansi Buku Keluar)</span>
            <span class="badge bg-dark">{{ $pinjamanLain->count() }} Buku</span>
        </div>
        <div class="card-body p-0">
            @if($pinjamanLain->isEmpty())
                <div class="text-center py-4 text-muted small">
                    Tidak ada siswa lain yang sedang meminjam buku saat ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Buku</th>
                                <th>Peminjam (Siswa)</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Estimasi Kembali</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pinjamanLain as $lain)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($lain->buku && $lain->buku->cover)
                                                <img src="{{ asset('assets/img/' . $lain->buku->cover) }}" alt="Cover" class="rounded me-3 border" style="width: 60px; height: 80px; object-fit: contain;">
                                            @else
                                                <div class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center me-3 text-muted small" style="width: 60px; height: 80px;">Cover</div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ optional($lain->buku)->judul ?? 'Judul Tidak Tersedia' }}</div>
                                                <div class="text-muted small">{{ optional($lain->buku)->pengarang ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-primary">{{ optional($lain->siswa)->nama_lengkap ?? 'Siswa' }}</span>
                                    </td>
                                    <td>{{ $lain->jumlah }} eks</td>
                                    <td>{{ $lain->tanggal_peminjaman ? \Carbon\Carbon::parse($lain->tanggal_peminjaman)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $lain->tanggal_pengembalian ? \Carbon\Carbon::parse($lain->tanggal_pengembalian)->format('d/m/Y') : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection