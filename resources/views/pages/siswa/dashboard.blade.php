@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid px-4 py-4" style="background-color: #fff; color: #000;">
    <!-- Header Title -->
    <h3 class="fw-bold mb-4" style="color: #000;">Dashboard Siswa</h3>

    <!-- Summary Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border border-dark rounded-0">
                <div class="card-body p-3">
                    <div class="small mb-3 text-dark">Sedang Dipinjam</div>
                    <h4 class="fw-bold mb-0 text-dark">{{ $totalDipinjam ?? '0 buku' }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border border-dark rounded-0">
                <div class="card-body p-3">
                    <div class="small mb-3 text-dark">Jatuh Tempo Terdekat</div>
                    <h4 class="fw-bold mb-0 text-dark">{{ $jatuhTempoTerdekat ?? '-' }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border border-dark rounded-0">
                <div class="card-body p-3">
                    <div class="small mb-3 text-dark">Total Denda</div>
                    <h4 class="fw-bold mb-0 text-dark">{{ isset($totalDenda) ? 'Rp ' . number_format($totalDenda, 0, ',', '.') : 'Rp 0' }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area: Table & Notifications -->
    <div class="row g-4">
        <!-- Table Peminjaman Aktif -->
        <div class="col-lg-8">
            <h6 class="fw-bold mb-3 text-dark">Peminjaman Aktif</h6>
            <div class="table-responsive">
                <table class="table table-bordered border-dark align-middle mb-0 rounded-0" style="border: 2px solid #000;">
                    <thead class="border-dark">
                        <tr>
                            <th class="fw-bold border-dark text-dark">Judul Buku</th>
                            <th class="fw-bold border-dark text-dark">Tgl Pinjam</th>
                            <th class="fw-bold border-dark text-dark">Jatuh Tempo</th>
                            <th class="fw-bold border-dark text-dark">Status</th>
                            <th class="fw-bold border-dark text-dark">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="border-dark">
                        @forelse ($peminjamanAktif ?? [] as $item)
                            <tr>
                                <td class="border-dark text-dark">{{ $item->buku->judul }}</td>
                                <td class="border-dark text-dark">{{ $item->tanggal_peminjaman->format('d M Y') }}</td>
                                <td class="border-dark text-dark">{{ $item->tanggal_kembali->format('d M Y') }}</td>
                                <td class="border-dark text-dark">{{ ucfirst($item->status) }}</td>
                                <td class="border-dark text-dark">Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <!-- Kondisi Tabel Kosong untuk User Baru -->
                            <tr>
                                <td colspan="5" class="border-dark text-dark text-center py-4">Belum ada buku yang sedang dipinjam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar Notifikasi -->
        <div class="col-lg-4">
            <div class="border border-dark rounded-0 p-3 h-100" style="border-width: 2px !important;">
                <h6 class="fw-bold border-bottom border-dark pb-3 mb-3 text-dark">Notifikasi</h6>
                <div class="d-flex flex-column gap-3">
                    
                    @forelse ($notifikasi ?? [] as $notif)
                        <div class="border border-dark rounded-0 p-2">
                            <div class="fw-bold small mb-1 text-dark">{{ $notif->judul }}</div>
                            <div class="small text-dark">{{ $notif->pesan }}</div>
                        </div>
                    @empty
                        <!-- Notifikasi Default untuk User Baru -->
                        <div class="border border-dark rounded-0 p-2">
                            <div class="fw-bold small mb-1 text-dark">Selamat Datang!</div>
                            <div class="small text-dark">Akun kamu berhasil dibuat. Silakan jelajahi koleksi buku di perpustakaan kami.</div>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
@endsection