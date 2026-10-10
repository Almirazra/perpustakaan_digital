@extends('layouts.app')

@section('title', 'Ubah siswa')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Ubah siswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Siswa</a></li>
        <li class="breadcrumb-item active">Ubah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">Ubah {{ $siswa->nama_lengkap }}</div>
        <div class="card-body">
            <form action="{{ route('siswa.update', $siswa) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}"
                               class="form-control @error('nis') is-invalid @enderror" required autofocus>
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_lengkap" class="form-label">Nama lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}"
                               class="form-control @error('nama_lengkap') is-invalid @enderror" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select id="kelas" name="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
                            <option value="">Pilih kelas</option>
                            @foreach ($DaftarKelas as $k)
                                <option value="{{ $k }}" @selected(old('kelas', $siswa->kelas) === $k)>{{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                    <div class="col-md-4 mb-3">
    <label for="jurusan" class="form-label">Jurusan</label>
    <select id="jurusan" name="jurusan" class="form-select @error('jurusan') is-invalid @enderror" required>
        <option value="">Pilih jurusan</option>
        @foreach ($DaftarJurusan as $kode => $nama)
            <option value="{{ $kode }}" @selected(old('jurusan', $siswa->jurusan) === $kode)>{{ $nama }}</option>
        @endforeach
    </select>
    @error('jurusan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                    <div class="col-md-4 mb-3">
                        <label for="telp" class="form-label">Telepon</label>
                        <input type="text" id="telp" name="telp" value="{{ old('telp', $siswa->telp) }}"
                               class="form-control @error('telp') is-invalid @enderror">
                        @error('telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
