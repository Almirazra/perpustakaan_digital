@extends('layouts.app')

@section('title', 'Tambah kategori')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah kategori</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">Form kategori baru</div>
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama kategori</label>
                    <input type="text" id="nama_kategori" name="nama_kategori"
                           value="{{ old('nama_kategori') }}"
                           class="form-control @error('nama_kategori') is-invalid @enderror" required autofocus>
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                              class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
