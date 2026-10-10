@extends('layouts.app')

@section('title', 'Siswa')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Siswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Siswa</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-user-graduate me-1"></i> Data Siswa</span>
            <div class="d-flex gap-2">
    <div class="dropdown">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fas fa-id-card me-1"></i> Cetak kartu
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('siswa.kartu.semua') }}" target="_blank">Semua siswa</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('siswa.kartu.semua', ['kelas' => 'X']) }}" target="_blank">Kelas X</a></li>
            <li><a class="dropdown-item" href="{{ route('siswa.kartu.semua', ['kelas' => 'XI']) }}" target="_blank">Kelas XI</a></li>
            <li><a class="dropdown-item" href="{{ route('siswa.kartu.semua', ['kelas' => 'XII']) }}" target="_blank">Kelas XII</a></li>
        </ul>
    </div>
    <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i> Tambah siswa
    </a>
</div>

        </div>
        <div class="card-body">
            <table id="tabel-siswa" class="table">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>NIS</th>
                        <th>Nama lengkap</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Telepon</th>
                        <th style="width:260px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswas as $s)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->nama_lengkap }}</td>
                            <td>{{ $s->kelas }}</td>
                            <td>{{ $s->jurusan }}</td>
                            <td>{{ $s->telp ?? '-' }}</td>
                            <td>
                                <a href="{{ route('siswa.show', $s) }}" class="btn btn-outline-secondary btn-sm">Detail</a>
                                <a href="{{ route('siswa.edit', $s) }}" class="btn btn-outline-primary btn-sm">Ubah</a>
                                <a href="{{ route('siswa.kartu', $s) }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="Cetak kartu">
                                        <i class="fas fa-id-card"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm btn-hapus"
                                        data-url="{{ route('siswa.destroy', $s) }}"
                                        data-nama="{{ $s->nama_lengkap }}">
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
        title: 'Hapus siswa?',
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

new simpleDatatables.DataTable('#tabel-siswa', {
    labels: {
        placeholder: 'Cari siswa...',
        perPage: 'data per halaman',
        noRows: 'Belum ada siswa',
        info: 'Menampilkan {start} sampai {end} dari {rows} data',
    },
});
</script>
@endpush
