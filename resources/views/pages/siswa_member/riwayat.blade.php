@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h1 class="h3 mb-0 text-dark fw-bold">Riwayat Peminjaman</h1>
            <p class="text-muted small mb-0">Daftar buku yang sudah pernah kamu pinjam dan kembalikan.</p>
        </div>
        <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Peminjaman Aktif
        </a>
    </div>

    <!-- Tabel Riwayat Peminjaman -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
            <span class="fw-semibold"><i class="fas fa-history me-2"></i>Arsip Riwayat Transaksi</span>
            <span class="badge bg-secondary">{{ $riwayats->count() }} Riwayat</span>
        </div>
        <div class="card-body p-0">
            @if($riwayats->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5 class="fw-bold text-dark">Belum Ada Riwayat</h5>
                    <p class="text-muted small mb-3">Kamu belum memiliki riwayat pengembalian buku.</p>
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
                                <th>Tanggal Dikembalikan</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Denda Dibayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayats as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($item->buku && $item->buku->cover)
                                                <img src="{{ asset('assets/img/' . $item->buku->cover) }}" alt="Cover" class="rounded me-3 border" style="width: 45px; height: 60px; object-fit: contain;">
                                            @else
                                                <div class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center me-3 text-muted small" style="width: 45px; height: 60px;">
                                                    Cover
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $item->buku->judul ?? 'Judul Tidak Tersedia' }}</div>
                                                <div class="text-muted small">
                                                    {{ $item->buku->pengarang ?? '-' }} • 
                                                    <span class="badge bg-light text-dark border">{{ optional($item->buku->kategori)->nama_kategori ?? 'Umum' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="fw-semibold">{{ $item->jumlah }}</span> eks</td>
                                    <td>{{ $item->tanggal_peminjaman ? $item->tanggal_peminjaman->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        {{ optional($item->pengembalian)->created_at ? optional($item->pengembalian)->created_at->format('d/m/Y') : $item->updated_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Dikembalikan</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        @if(optional($item->pengembalian)->denda > 0)
                                            <span class="text-danger fw-semibold">Rp {{ number_format(optional($item->pengembalian)->denda, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">Rp 0</span>
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
</div>
@endsection