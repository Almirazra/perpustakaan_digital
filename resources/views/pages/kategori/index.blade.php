@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Kategori</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Kategori</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tags me-1"></i> Data Kategori</span>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah kategori
            </a>
        </div>
        <div class="card-body">
            <table id="tabel-kategori" class="table">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Nama kategori</th>
                        <th>Keterangan</th>
                        <th style="width:100px">Jumlah buku</th>
                        <th style="width:130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategoris as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama_kategori }}</td>
                            <td>{{ $k->keterangan ?? '-' }}</td>
                            <td>{{ $k->bukus_count }}</td>
                            <td>
                                <a href="{{ route('kategori.edit', $k) }}" class="btn btn-outline-primary btn-sm">Ubah</a>
                                <button type="button" class="btn btn-outline-danger btn-sm btn-hapus"
                                        data-url="{{ route('kategori.destroy', $k) }}"
                                        data-nama="{{ $k->nama_kategori }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="formHapus" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('script')
<script>
document.addEventListener('click', (e) => {
    const tombol = e.target.closest('.btn-hapus');
    if (!tombol) return;

    Swal.fire({
        title: 'Hapus kategori?',
        text: '"' + tombol.dataset.nama + '" akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3E4A56',
        cancelButtonColor: '#74879A',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
    }).then((hasil) => {
        if (hasil.isConfirmed) {
            const f = document.getElementById('formHapus');
            f.action = tombol.dataset.url;
            f.submit();
        }
    });
});

@if (session('success'))
    Swal.fire({ icon: 'success', title: @json(session('success')), confirmButtonColor: '#3E4A56', timer: 2000, showConfirmButton: false });
@endif
@if (session('error'))
    Swal.fire({ icon: 'error', title: 'Gagal', text: @json(session('error')), confirmButtonColor: '#3E4A56' });
@endif

new simpleDatatables.DataTable('#tabel-kategori', {
    labels: {
        placeholder: 'Cari kategori...',
        perPage: 'data per halaman',
        noRows: 'Belum ada kategori',
        info: 'Menampilkan {start} sampai {end} dari {rows} data',
    },
});
</script>
@endpush
