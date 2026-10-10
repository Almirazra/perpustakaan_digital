@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Notifikasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Notifikasi</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>
                <i class="fas fa-bell me-1"></i> Notifikasi siswa
                @if ($jumlahBelum > 0)
                    <span class="badge bg-danger ms-1">{{ $jumlahBelum }} belum dibaca</span>
                @endif
            </span>

            <div class="d-flex gap-2">
                <div class="btn-group btn-group-sm" role="group" aria-label="Filter status">
                    <a href="{{ route('notifikasi.index') }}" class="btn {{ $status === null ? 'btn-primary' : 'btn-outline-primary' }}">Semua</a>
                    <a href="{{ route('notifikasi.index', ['status' => 'belum_dibaca']) }}" class="btn {{ $status === 'belum_dibaca' ? 'btn-primary' : 'btn-outline-primary' }}">Belum dibaca</a>
                    <a href="{{ route('notifikasi.index', ['status' => 'dibaca']) }}" class="btn {{ $status === 'dibaca' ? 'btn-primary' : 'btn-outline-primary' }}">Dibaca</a>
                </div>

                @if ($jumlahBelum > 0)
                    <form action="{{ route('notifikasi.dibaca-semua') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Tandai semua dibaca</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="card-body">
            <table id="tabel-notifikasi" class="table">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Siswa</th>
                        <th>Judul</th>
                        <th>Pesan</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th style="width:230px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifikasis as $n)
                        @php
                            $hp = preg_replace('/^0/', '62', preg_replace('/\D/', '', $n->siswa->telp ?? ''));
                            $baru = $n->status === 'belum_dibaca';
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $n->siswa->nama_lengkap }}
                                <div class="small text-muted">{{ $n->siswa->kelas }} {{ $n->siswa->jurusan }}</div>
                            </td>
                            <td class="{{ $baru ? 'fw-bold' : '' }}">{{ $n->judul }}</td>
                            <td>{{ $n->pesan }}</td>
                            <td>
                                {{ $n->created_at->format('d/m/Y H:i') }}
                                <div class="small text-muted">{{ $n->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                @if ($baru)
                                    <span class="badge bg-warning text-dark">Belum dibaca</span>
                                @else
                                    <span class="badge bg-secondary">Dibaca</span>
                                @endif
                            </td>
                            <td>
                                @if ($hp !== '')
                                    <a href="https://wa.me/{{ $hp }}?text={{ urlencode($n->judul . ': ' . $n->pesan) }}"
                                       target="_blank" rel="noopener" class="btn btn-outline-success btn-sm" title="Kirim lewat WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                @endif

                                @if ($baru)
                                    <form action="{{ route('notifikasi.dibaca', $n) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Tandai dibaca</button>
                                    </form>
                                @endif

                                <button type="button" class="btn btn-outline-danger btn-sm btn-hapus"
                                        data-url="{{ route('notifikasi.destroy', $n) }}"
                                        data-nama="{{ $n->judul }}">
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
        title: 'Hapus notifikasi?',
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
    Swal.fire({ icon: 'success', title: @json(session('success')), confirmButtonColor: '#3E4A56', timer: 2500, showConfirmButton: false });
@endif
@if (session('error'))
    Swal.fire({ icon: 'error', title: 'Gagal', text: @json(session('error')), confirmButtonColor: '#3E4A56' });
@endif

new simpleDatatables.DataTable('#tabel-notifikasi', {
    labels: {
        placeholder: 'Cari notifikasi...',
        perPage: 'data per halaman',
        noRows: 'Belum ada notifikasi',
        info: 'Menampilkan {start} sampai {end} dari {rows} data',
    },
});
</script>
@endpush
