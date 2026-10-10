@extends('layouts.app')

@section('title', 'Denda')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Denda</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Denda</li>
    </ol>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="small">Belum dibayar ({{ $jumlahBelum }} denda)</div>
                    <div class="fs-3 fw-bold">Rp{{ number_format($totalBelum, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="small">Sudah dibayar</div>
                    <div class="fs-3 fw-bold">Rp{{ number_format($totalLunas, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-coins me-1"></i> Data Denda</span>
            <div class="btn-group btn-group-sm" role="group" aria-label="Filter status">
                <a href="{{ route('denda.index') }}" class="btn {{ $status === null ? 'btn-primary' : 'btn-outline-primary' }}">Semua</a>
                <a href="{{ route('denda.index', ['status' => 'belum_bayar']) }}" class="btn {{ $status === 'belum_bayar' ? 'btn-primary' : 'btn-outline-primary' }}">Belum bayar</a>
                <a href="{{ route('denda.index', ['status' => 'lunas']) }}" class="btn {{ $status === 'lunas' ? 'btn-primary' : 'btn-outline-primary' }}">Lunas</a>
            </div>
        </div>
        <div class="card-body">
            <table id="tabel-denda" class="table">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Nama siswa</th>
                        <th>Judul buku</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th style="width:150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dendas as $d)
                        @php $p = $d->pengembalian->peminjaman; @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->siswa->nama_lengkap }}<div class="small text-muted">{{ $p->siswa->kelas }} {{ $p->siswa->jurusan }}</div></td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $d->keterangan ?? '-' }}</td>
                            <td>Rp{{ number_format($d->jumlah, 0, ',', '.') }}</td>
                            <td>
                                @if ($d->status_bayar === 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum bayar</span>
                                @endif
                            </td>
                            <td>
                                @if ($d->status_bayar === 'belum_bayar')
                                    <button type="button" class="btn btn-primary btn-sm btn-status"
                                            data-url="{{ route('denda.update', $d) }}"
                                            data-status="lunas"
                                            data-judul="Tandai denda lunas?"
                                            data-teks="Denda {{ $p->siswa->nama_lengkap }} sebesar Rp{{ number_format($d->jumlah, 0, ',', '.') }} dicatat sudah dibayar.">
                                        Tandai lunas
                                    </button>
                                @elseif (Auth::user()->role === 'admin')
                                    <button type="button" class="btn btn-outline-secondary btn-sm btn-status"
                                            data-url="{{ route('denda.update', $d) }}"
                                            data-status="belum_bayar"
                                            data-judul="Batalkan pelunasan?"
                                            data-teks="Denda {{ $p->siswa->nama_lengkap }} akan kembali berstatus belum bayar.">
                                        Batalkan
                                    </button>
                                @else
                                    <span class="text-muted small">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="formStatus" method="POST" class="d-none">
    @csrf
    @method('PUT')
    <input type="hidden" name="status_bayar" id="inputStatus">
</form>
@endsection

@push('script')
<script>
document.addEventListener('click', (e) => {
    const tombol = e.target.closest('.btn-status');
    if (!tombol) return;

    Swal.fire({
        title: tombol.dataset.judul,
        text: tombol.dataset.teks,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3E4A56',
        cancelButtonColor: '#74879A',
        confirmButtonText: 'Ya, lanjutkan',
        cancelButtonText: 'Batal',
    }).then((hasil) => {
        if (hasil.isConfirmed) {
            const f = document.getElementById('formStatus');
            f.action = tombol.dataset.url;
            document.getElementById('inputStatus').value = tombol.dataset.status;
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

new simpleDatatables.DataTable('#tabel-denda', {
    labels: {
        placeholder: 'Cari denda...',
        perPage: 'data per halaman',
        noRows: 'Tidak ada denda',
        info: 'Menampilkan {start} sampai {end} dari {rows} data',
    },
});
</script>
@endpush
