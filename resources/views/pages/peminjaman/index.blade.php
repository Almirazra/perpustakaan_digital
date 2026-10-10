@extends('layouts.app')

@section('title', 'Peminjaman')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Peminjaman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Peminjaman</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-hand-holding me-1"></i> Data Peminjaman Buku</span>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah peminjaman
            </a>
        </div>
        <div class="card-body">
            <table id="tabel-peminjaman" class="table">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Nama siswa</th>
                        <th>Judul buku</th>
                        <th>Tgl pinjam</th>
                        <th>Jatuh tempo</th>
                        <th style="width:70px">Jumlah</th>
                        <th>Status</th>
                        <th style="width:190px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjamans as $p)
                        @php $telat = $p->status === 'dipinjam' && $p->tanggal_kembali->lt(today()); @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->siswa->nama_lengkap }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tanggal_peminjaman->format('d/m/Y') }}</td>
                            <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                            <td>{{ $p->jumlah }}</td>
                            <td>
                                @if ($p->status === 'dikembalikan')
                                    <span class="badge bg-success">Dikembalikan</span>
                                @elseif ($telat)
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @endif
                            </td>
                            <td>
                                @if ($p->status === 'dipinjam')
                                    <form action="{{ route('peminjaman.kembalikan', $p) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Kembalikan</button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-hapus"
                                            data-url="{{ route('peminjaman.destroy', $p) }}"
                                            data-nama="{{ $p->siswa->nama_lengkap }}">
                                        Hapus
                                    </button>
                                @endif
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
        title: 'Hapus data peminjaman?',
        text: 'Data milik ' + tombol.dataset.nama + ' akan dihapus permanen.',
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
    Swal.fire({ icon: 'success', title: @json(session('success')), confirmButtonColor: '#3E4A56', timer: 2500, showConfirmButton: false });
@endif
@if (session('error'))
    Swal.fire({ icon: 'error', title: 'Gagal', text: @json(session('error')), confirmButtonColor: '#3E4A56' });
@endif

new simpleDatatables.DataTable('#tabel-peminjaman', {
    labels: {
        placeholder: 'Cari peminjaman...',
        perPage: 'data per halaman',
        noRows: 'Belum ada peminjaman',
        info: 'Menampilkan {start} sampai {end} dari {rows} data',
    },
});
</script>
@endpush
