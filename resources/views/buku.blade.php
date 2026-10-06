@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Buku</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Buku</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table me-1"></i> Data Buku</div>
        <div class="card-body">
            <table id="tabel-buku" class="table">
                <thead>
                    <tr><th>Cover</th><th>Judul</th><th>Pengarang</th><th>Kategori</th><th>Stok</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
fetch('/api/buku', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
    .then(r => r.json())
    .then(json => {
        document.querySelector('#tabel-buku tbody').innerHTML = json.data.map(b => `
            <tr>
                <td><img src="${b.cover_url ?? 'https://placehold.co/60x80?text=-'}" width="50" alt=""></td>
                <td>${b.judul}</td>
                <td>${b.pengarang}</td>
                <td>${b.kategori?.nama_kategori ?? '-'}</td>
                <td>${b.stok}</td>
            </tr>`).join('');

        new simpleDatatables.DataTable('#tabel-buku');
    });
</script>
@endpush
