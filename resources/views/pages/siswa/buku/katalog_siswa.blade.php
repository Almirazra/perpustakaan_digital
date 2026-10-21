```blade
@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row g-4">

        {{-- BAGIAN KATALOG BUKU --}}
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Katalog Buku</h3>
                    <p class="text-muted mb-0">
                        Temukan buku yang ingin kamu baca.
                    </p>
                </div>
            </div>

            {{-- FORM PENCARIAN --}}
            <form action="{{ route('siswa.buku.index') }}"
                  method="GET"
                  class="row g-2 mb-4">

                <div class="col-md-6">
                    <input
                        type="text"
                        name="keyword"
                        class="form-control"
                        placeholder="Cari judul atau pengarang..."
                        value="{{ request('keyword') }}"
                    >
                </div>

                <div class="col-md-4">
                    <select name="kategori_id" class="form-select">
                        <option value="">Semua Kategori</option>

                        @foreach ($kategori as $kat)
                            <option
                                value="{{ $kat->id }}"
                                {{ request('kategori_id') == $kat->id ? 'selected' : '' }}
                            >
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">
                        Cari
                    </button>
                </div>
            </form>

            {{-- DAFTAR BUKU --}}
            <div class="row g-3">
                @forelse ($buku as $item)
                    <div class="col-sm-6 col-xl-4">
                        <div class="card h-100 shadow-sm border-0">
                            @if ($item->cover)
                                <img
                                    src="{{ asset('storage/' . $item->cover) }}"
                                    class="card-img-top"
                                    alt="Cover {{ $item->judul }}"
                                    style="height: 230px; object-fit: contain; padding: 12px;"
                                >
                            @else
                                <div
                                    class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 230px;"
                                >
                                    <span class="text-muted">Tidak ada cover</span>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold mb-2">
                                    {{ $item->judul }}
                                </h6>

                                <p class="text-muted small mb-1">
                                    Pengarang: {{ $item->pengarang }}
                                </p>

                                <p class="text-muted small mb-3">
                                    Kategori:
                                    {{ $item->kategori->nama_kategori ?? 'Belum ada kategori' }}
                                </p>

                                <a
                                    href="{{ route('siswa.buku.index', array_merge(request()->query(), ['detail_id' => $item->id])) }}"
                                    class="btn btn-outline-primary btn-sm mt-auto"
                                >
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            Buku tidak ditemukan. Coba gunakan kata kunci lain.
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="mt-4">
                {{ $buku->links() }}
            </div>
        </div>

        {{-- BAGIAN DETAIL BUKU --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Buku</h5>
                </div>

                <div class="card-body">
                    @if ($detailBuku)
                        @if ($detailBuku->cover)
                            <div class="text-center mb-3">
                                <img
                                    src="{{ asset('storage/' . $detailBuku->cover) }}"
                                    alt="Cover {{ $detailBuku->judul }}"
                                    style="max-width: 180px; max-height: 240px; object-fit: contain;"
                                >
                            </div>
                        @endif

                        <h5 class="fw-bold">
                            {{ $detailBuku->judul }}
                        </h5>

                        <hr>

                        <p>
                            <strong>Pengarang:</strong><br>
                            {{ $detailBuku->pengarang ?? '-' }}
                        </p>

                        <p>
                            <strong>Penerbit:</strong><br>
                            {{ $detailBuku->penerbit ?? '-' }}
                        </p>

                        <p>
                            <strong>Tahun Terbit:</strong><br>
                            {{ $detailBuku->tahun_terbit ?? '-' }}
                        </p>

                        <p>
                            <strong>Kategori:</strong><br>
                            {{ $detailBuku->kategori->nama_kategori ?? '-' }}
                        </p>

                        <p>
                            <strong>Sinopsis:</strong><br>
                            {{ $detailBuku->sinopsis ?? 'Sinopsis belum tersedia.' }}
                        </p>
                    @else
                        <p class="text-muted mb-0">
                            Belum ada buku yang dapat ditampilkan.
                        </p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
```