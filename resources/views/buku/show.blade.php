@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Buku</h6>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Judul Buku</th>
                    <td>{{ $buku->judul }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $buku->kategori ? $buku->kategori->nama_kategori : '-' }}</td>
                </tr>
                <tr>
                    <th>Pengarang</th>
                    <td>{{ $buku->pengarang }}</td>
                </tr>
                <tr>
                    <th>Penerbit</th>
                    <td>{{ $buku->penerbit }}</td>
                </tr>
                <tr>
                    <th>Tahun Terbit</th>
                    <td>{{ $buku->tahun_terbit }}</td>
                </tr>
                <tr>
                    <th>Stok Tersedia</th>
                    <td>
                        @if($buku->stok > 0)
                            <span class="badge bg-success text-white">{{ $buku->stok }} Tersedia</span>
                        @else
                            <span class="badge bg-danger text-white">Habis</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Lokasi Rak</th>
                    <td>{{ $buku->lokasi_rak ?? 'Belum ditentukan' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection