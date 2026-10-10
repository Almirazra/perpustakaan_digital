@extends('layouts.app')

@section('title', 'Tambah peminjaman')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah peminjaman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('peminjaman.index') }}">Peminjaman</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">Form peminjaman baru</div>
        <div class="card-body">
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="siswa_id" class="form-label">Siswa</label>
                        <select id="siswa_id" name="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                            <option value="">Pilih siswa</option>
                            @foreach ($siswas as $s)
                                <option value="{{ $s->id }}" @selected(old('siswa_id') == $s->id)>
                                    {{ $s->nama_lengkap }} ({{ $s->nis }}) - {{ $s->kelas }} {{ $s->jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="buku_id" class="form-label">Buku</label>
                        <select id="buku_id" name="buku_id" class="form-select @error('buku_id') is-invalid @enderror" required>
                            <option value="">Pilih buku</option>
                            @foreach ($bukus as $b)
                                <option value="{{ $b->id }}" data-stok="{{ $b->stok }}" @selected(old('buku_id') == $b->id)>
                                    {{ $b->judul }} (stok {{ $b->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="tanggal_peminjaman" class="form-label">Tanggal pinjam</label>
                        <input type="date" id="tanggal_peminjaman" name="tanggal_peminjaman"
                               value="{{ old('tanggal_peminjaman', today()->toDateString()) }}"
                               class="form-control @error('tanggal_peminjaman') is-invalid @enderror" required>
                        @error('tanggal_peminjaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tanggal_kembali" class="form-label">Jatuh tempo</label>
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                               value="{{ old('tanggal_kembali', today()->addDays(7)->toDateString()) }}"
                               class="form-control @error('tanggal_kembali') is-invalid @enderror" required>
                        @error('tanggal_kembali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" min="1" value="{{ old('jumlah', 1) }}"
                               class="form-control @error('jumlah') is-invalid @enderror" required>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
const pilihBuku = document.getElementById('buku_id');
const inputJumlah = document.getElementById('jumlah');

pilihBuku.addEventListener('change', () => {
    const stok = pilihBuku.selectedOptions[0]?.dataset.stok;
    inputJumlah.max = stok || '';
    if (stok && Number(inputJumlah.value) > Number(stok)) {
        inputJumlah.value = stok;
    }
});
</script>
@endpush
