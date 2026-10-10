@extends('layouts.app')

@section('title', 'Detail siswa')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ $siswa->nama_lengkap }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Siswa</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">Informasi siswa</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">NIS</dt>
                <dd class="col-sm-9">{{ $siswa->nis }}</dd>
                <dt class="col-sm-3">Nama lengkap</dt>
                <dd class="col-sm-9">{{ $siswa->nama_lengkap }}</dd>
                <dt class="col-sm-3">Kelas</dt>
                <dd class="col-sm-9">{{ $siswa->kelas }} {{ $siswa->jurusan }}</dd>
                <dt class="col-sm-3">Telepon</dt>
                <dd class="col-sm-9">{{ $siswa->telp ?? '-' }}</dd>
                <dt class="col-sm-3">Terdaftar</dt>
                <dd class="col-sm-9">{{ $siswa->created_at->format('d/m/Y') }}</dd>
            </dl>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Riwayat peminjaman ({{ $siswa->peminjamans->count() }})</div>
        <div class="card-body">
            <table class="table table-sm align-middle mb-0">
                <thead>
                    <tr><th>Buku</th><th>Tanggal pinjam</th><th>Jatuh tempo</th><th>Jumlah</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($siswa->peminjamans as $p)
                        <tr>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tanggal_peminjaman->format('d/m/Y') }}</td>
                            <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                            <td>{{ $p->jumlah }}</td>
                            <td>
                                <span class="badge {{ $p->status === 'dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Belum pernah meminjam buku.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-primary">Ubah</a>
    <a href="{{ route('siswa.kartu', $siswa) }}" target="_blank" class="btn btn-outline-secondary">
    <i class="fas fa-id-card me-1"></i> Cetak kartu
</a>
</div>
@endsection
