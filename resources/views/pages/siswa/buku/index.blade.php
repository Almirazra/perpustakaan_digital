@extends('layouts.app') {{-- Sesuaikan nama layout utama kamu --}}

@section('content')
<div class="container-fluid py-3">
    <div class="row">
         <h1 class="mt-4">Daftar Buku</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Buku</li>
    </ol>
        {{-- BAGIAN KIRI & TENGAH: Pencarian & Katalog Buku --}}
        <div class="col-lg-8">
            <h4 class="fw-bold mb-3">Daftar Buku</h4>

            {{-- Form Pencarian & Filter Kategori --}}
            <form action="{{ route('siswa.buku.index') }}" method="GET" class="row g-2 mb-4">
                <div class="col-md-6">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari judul / penulis / kategori..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="Novel" {{ request('kategori') == 'Novel' ? 'selected' : '' }}>Novel</option>
                        <option value="Pelajaran" {{ request('kategori') == 'Pelajaran' ? 'selected' : '' }}>Pelajaran</option>
                        <option value="Komik" {{ request('kategori') == 'Komik' ? 'selected' : '' }}>Komik</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark w-100 fw-bold">Cari</button>
                </div>
            </form>

            {{-- Grid Daftar Buku --}}
            <div class="row row-cols-1 row-cols-md-3 g-3">
                @forelse($bukus as $buku)
                    <div class="col">
                        <div class="card h-100 shadow-sm border text-center p-2">
                            <div class="bg-light border d-flex align-items-center justify-content-center mb-2" style="height: 160px;">
                                @if($buku->cover)
                                    <img src="{{ asset('storage/' . $buku->cover) }}" class="img-fluid h-100" style="object-fit: cover;" alt="Cover">
                                @else
                                    <span class="text-muted fw-bold">Cover</span>
                                @endif
                            </div>
                            <h6 class="fw-bold text-truncate mb-1">{{ $buku->judul }}</h6>
                            <p class="text-muted small mb-2 text-truncate">{{ $buku->penulis }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                @if($buku->stok > 0)
                                    <span class="badge bg-outline-secondary border text-dark">Tersedia</span>
                                @else
                                    <span class="badge bg-secondary">Dipinjam</span>
                                @endif

                                <a href="{{ route('siswa.buku.index', array_merge(request()->query(), ['detail_id' => $buku->id])) }}" class="btn btn-sm btn-outline-dark">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">Buku tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-start mt-4">
                {{ $bukus->links() }}
            </div>
        </div>

        {{-- BAGIAN KANAN: Panel Detail Buku --}}
        <div class="col-lg-4">
            <div class="card border p-3 shadow-sm">
                <h5 class="fw-bold border-bottom pb-2">Detail Buku</h5>

                @if($detailBuku)
                    <div class="text-center my-3">
                        <div class="bg-light border d-inline-flex align-items-center justify-content-center" style="width: 140px; height: 180px;">
                            @if($detailBuku->cover)
                                <img src="{{ asset('storage/' . $detailBuku->cover) }}" class="img-fluid h-100" style="object-fit: cover;" alt="Cover">
                            @else
                                <span class="text-muted fw-bold">Cover</span>
                            @endif
                        </div>
                    </div>

                    <h5 class="fw-bold mb-1">{{ $detailBuku->judul }}</h5>
                    <p class="text-muted small mb-2">{{ $detailBuku->penulis }}</p>

                    <div class="small mb-3">
                        <div><strong>Penerbit:</strong> {{ $detailBuku->penerbit ?? '-' }}</div>
                        <div><strong>Tahun:</strong> {{ $detailBuku->tahun ?? '-' }}</div>
                        <div><strong>Kategori:</strong> {{ $detailBuku->kategori ?? '-' }}</div>
                        <div><strong>Stok:</strong> {{ $detailBuku->stok }} eksemplar</div>
                    </div>

                    <h6 class="fw-bold">Deskripsi</h6>
                    <p class="text-muted small border-bottom pb-3" style="min-height: 80px;">
                        {{ $detailBuku->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                    </p>

                    {{-- Form/Tombol Pinjam Buku --}}
                    @if($detailBuku->stok > 0)
                        <form action="{{ route('siswa.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="buku_id" value="{{ $detailBuku->id }}">
                            <button type="submit" class="btn btn-dark w-100 fw-bold mb-2 py-2">PINJAM BUKU</button>
                        </form>
                    @else
                        <button class="btn btn-secondary w-100 fw-bold mb-2 py-2" disabled>STOK HABIS</button>
                    @endif

                    <a href="{{ route('siswa.buku.index') }}" class="btn btn-outline-secondary w-100">Kembali</a>
                @else
                    <p class="text-muted text-center py-5">Pilih buku untuk melihat detail.</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
