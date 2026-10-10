@extends('layouts.app')

@section('title', 'Pengembalian')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengembalian</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengembalian</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-rotate-left me-1"></i> Riwayat Pengembalian Buku</span>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-primary btn-sm">Ke halaman peminjaman</a>
        </div>
        <div class="card-body">
            <table id="tabel-pengembalian" class="table">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Nama siswa</th>
                        <th>Judul buku</th>
                        <th>Tgl pinjam</th>
                        <th>Jatuh tempo</th>
                        <th>Tgl kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengembalians as $k)
                        @php $p = $k->peminjaman; @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->siswa->nama_lengkap }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tanggal_peminjaman->format('d/m/Y') }}</td>
                            <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                            <td>{{ $k->tanggal_pengembalian->format('d/m/Y') }}</td>
                            <td>
                                @if ($k->keterlambatan > 0)
                                    <span class="badge bg-danger">Terlambat {{ $k->keterlambatan }} hari</span>
                                @else
                                    <span class="badge bg-success">Tepat waktu</span>
                                @endif
                            </td>
                            <td>{{ $k->denda > 0 ? 'Rp' . number_format($k->denda, 0, ',', '.') : '-' }}</td>
                            <td>
                                @if ($k->dendaDetail)
                                    @if ($k->dendaDetail->status_bayar === 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum bayar</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
@if (session('success'))
    Swal.fire({ icon: 'success', title: @json(session('success')), confirmButtonColor: '#3E4A56', timer: 2500, showConfirmButton: false });
@endif
@if (session('error'))
    Swal.fire({ icon: 'error', title: 'Gagal', text: @json(session('error')), confirmButtonColor: '#3E4A56' });
@endif

new simpleDatatables.DataTable('#tabel-pengembalian', {
    labels: {
        placeholder: 'Cari pengembalian...',
        perPage: 'data per halaman',
        noRows: 'Belum ada pengembalian',
        info: 'Menampilkan {start} sampai {end} dari {rows} data',
    },
});
</script>
@endpush
