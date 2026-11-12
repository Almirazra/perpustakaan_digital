@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row g-4">

        {{-- BAGIAN KIRI: DAFTAR BUKU & PENCARIAN (col-lg-8) --}}
        <div class="col-lg-8">
            <div class="mb-4">
                <h3 class="fw-bold mb-1">Daftar Buku</h3>
            </div>

            {{-- FORM PENCARIAN & KATEGORI --}}
            <form action="{{ route('siswa.buku.index') }}" method="GET" class="row g-2 mb-4">
                <div class="col-md-7">
                    <input
                        type="text"
                        name="keyword"
                        class="form-control"
                        placeholder="Cari judul / penulis / kategori..."
                        value="{{ request('keyword') }}"
                    >
                </div>

                <div class="col-md-3">
                    <select name="kategori_id" class="form-select">
                        <option value="">Kategori</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark text-white fw-bold">
                        Cari
                    </button>
                </div>
            </form>

            {{-- GRID DAFTAR BUKU --}}
            <div class="row g-3">
                @forelse ($buku as $item)
                    <div class="col-sm-6 col-md-4">
                        <div class="card h-100 shadow-sm border {{ isset($detailBuku) && $detailBuku->id == $item->id ? 'border-dark' : 'border-light' }}">
                            @if ($item->cover)
                                <img
                                    src="{{ asset('assets/img/' . $item->cover) }}"
                                    class="card-img-top"
                                    alt="Cover {{ $item->judul }}"
                                    style="height: 180px; object-fit: contain; padding: 10px;"
                                >
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <span class="text-muted small">Cover</span>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="fw-bold mb-1 text-truncate" title="{{ $item->judul }}">
                                    {{ $item->judul }}
                                </h6>
                                <p class="text-muted small mb-3">
                                    {{ $item->pengarang }}
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    @if($item->stok > 0)
                                        <span class="badge bg-light text-dark border">Tersedia</span>
                                    @else
                                        <span class="badge bg-danger">Dipinjam</span>
                                    @endif

                                    <a
                                        href="{{ route('siswa.buku.index', array_merge(request()->query(), ['detail_id' => $item->id])) }}"
                                        class="btn btn-outline-dark btn-sm px-3"
                                    >
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Buku tidak ditemukan.</div>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="mt-4">
                {{ $buku->links() }}
            </div>
        </div>

        {{-- BAGIAN KANAN: DETAIL BUKU (col-lg-4) --}}
        <div class="col-lg-4">
            <div class="card border shadow-sm">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold">Detail Buku</h5>
                </div>

                <div class="card-body p-4">
                    @if ($detailBuku)
                        <div class="text-center mb-3">
                            @if ($detailBuku->cover)
                                <img
                                    src="{{ asset('assets/img/' . $detailBuku->cover) }}"
                                    alt="Cover {{ $detailBuku->judul }}"
                                    class="img-fluid border rounded"
                                    style="max-height: 200px; object-fit: contain;"
                                >
                            @else
                                <div class="bg-light p-4 text-muted border rounded">Cover</div>
                            @endif
                        </div>

                        <h5 class="fw-bold mb-1">{{ $detailBuku->judul }}</h5>
                        <p class="text-muted small mb-3">{{ $detailBuku->pengarang }}</p>

                        <div class="small mb-3">
                            <p class="mb-1"><strong>Penerbit:</strong> {{ $detailBuku->penerbit ?? '-' }}</p>
                            <p class="mb-1"><strong>Tahun:</strong> {{ $detailBuku->tahun_terbit ?? '-' }}</p>
                            <p class="mb-1"><strong>Kategori:</strong> {{ $detailBuku->kategori->nama_kategori ?? '-' }}</p>
                            <p class="mb-1"><strong>Lokasi Rak:</strong> {{ $detailBuku->lokasi_rak ?? '-' }}</p>
                            <p class="mb-0"><strong>Stok:</strong> {{ $detailBuku->stok ?? 0 }} eksemplar</p>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="fw-bold">Deskripsi</h6>
                            <p class="text-muted small" style="line-height: 1.5; white-space: pre-line;">
                                {{ $detailBuku->sinopsis ?? 'Deskripsi atau sinopsis belum tersedia untuk buku ini.' }}
                            </p>
                        </div>

                        {{-- TOMBOL AKSI PINJAM --}}
                        <div class="d-grid gap-2">
                            @if($detailBuku->stok > 0)
                                <form action="{{ route('peminjaman.store') }}" method="POST">
                                    @csrf
                                    {{-- Mengambil ID siswa secara otomatis berdasarkan nama user yang sedang login --}}
                                    <input type="hidden" name="siswa_id" value="{{ optional(\App\Models\SiswaModel::where('nama_lengkap', Auth::user()->name)->first())->id }}">
                                    <input type="hidden" name="buku_id" value="{{ $detailBuku->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn btn-dark fw-bold py-2 w-100" onclick="return confirm('Yakin ingin meminjam buku ini?')">
                                        PINJAM BUKU
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-secondary fw-bold py-2 w-100" disabled>
                                    STOK HABIS
                                </button>
                            @endif

                            <a href="{{ route('siswa.buku.index') }}" class="btn btn-outline-secondary btn-sm">
                                Kembali
                            </a>
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">Pilih buku untuk melihat detail.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection