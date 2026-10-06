@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Selamat datang, {{ Auth::user()->name }}</li>
    </ol>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="small">Total Buku</div>
                    <div class="fs-2 fw-bold">{{ $totalBuku }}</div>
                </div>
                <div class="card-footer"><a class="small text-white stretched-link" href="{{ url('/buku') }}">Lihat data</a></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="small">Total Siswa</div>
                    <div class="fs-2 fw-bold">{{ $totalSiswa }}</div>
                </div>
                <div class="card-footer"><a class="small text-white stretched-link" href="{{ url('/siswa') }}">Lihat data</a></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-dark mb-4">
                <div class="card-body">
                    <div class="small">Sedang Dipinjam</div>
                    <div class="fs-2 fw-bold">{{ $sedangDipinjam }}</div>
                </div>
                <div class="card-footer"><a class="small text-dark stretched-link" href="{{ url('/peminjaman') }}">Lihat data</a></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="small">Denda Belum Dibayar</div>
                    <div class="fs-2 fw-bold">Rp{{ number_format($dendaBelumBayar, 0, ',', '.') }}</div>
                </div>
                <div class="card-footer"><a class="small text-white stretched-link" href="{{ url('/denda') }}">Lihat data</a></div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table me-1"></i> Peminjaman Terbaru</div>
        <div class="card-body">
            <table class="table table-sm align-middle mb-0">
                <thead>
                    <tr><th>Siswa</th><th>Buku</th><th>Tanggal Pinjam</th><th>Jatuh Tempo</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($terbaru as $p)
                        <tr>
                            <td>{{ $p->siswa->nama_lengkap }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tanggal_peminjaman->format('d/m/Y') }}</td>
                            <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge {{ $p->status === 'dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Belum ada peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
