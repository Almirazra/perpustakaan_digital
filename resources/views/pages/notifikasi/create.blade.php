@extends('layouts.app')

@section('title', 'Kirim Notifikasi')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Kirim Notifikasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('notifikasi.index') }}">Notifikasi</a></li>
        <li class="breadcrumb-item active">Kirim</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-paper-plane me-1"></i> Form Kirim Pesan ke Siswa
        </div>
        <div class="card-body">
            <form action="{{ route('notifikasi.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="siswa_id" class="form-label fw-bold">Pilih Siswa Tujuan</label>
                    <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach ($siswas as $s)
                            <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name ?? $s->nama_lengkap }} {{ isset($s->kelas) ? '('.$s->kelas.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('siswa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="judul" class="form-label fw-bold">Judul Pesan</label>
                    <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Contoh: Pengembalian Buku Terlambat" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pesan" class="form-label fw-bold">Isi Pesan</label>
                    <textarea name="pesan" id="pesan" rows="4" class="form-control @error('pesan') is-invalid @enderror" placeholder="Tuliskan pesan atau pemberitahuan untuk siswa di sini..." required>{{ old('pesan') }}</textarea>
                    @error('pesan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('notifikasi.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Kirim Notifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
