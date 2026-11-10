@extends('layouts.app')

@section('title', 'Pesan Masuk Siswa')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0 text-dark">
            <i class="fas fa-envelope-open-text me-2"></i>Pesan Masuk
        </h3>
        <a href="{{ route('home') }}" class="btn btn-outline-dark btn-sm rounded-0">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="card shadow-sm border border-dark rounded-0">
        <div class="card-body p-0">
            <div class="list-group list-group-flush rounded-0">
                @forelse ($notifikasis ?? [] as $notif)
                    <div class="list-group-item p-4 border-bottom border-dark {{ $notif->status === 'dibaca' ? 'bg-white' : 'bg-light' }}">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold text-dark">
                                @if($notif->status === 'belum_dibaca')
                                    <span class="badge bg-danger rounded-pill me-2" style="font-size: 0.6rem;">Baru</span>
                                @endif
                                {{ $notif->judul }}
                            </h6>
                            <small class="text-muted">{{ $notif->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <p class="mb-1 text-dark">{{ $notif->pesan }}</p>
                        <small class="text-muted fw-semibold">Dari: Admin / Sistem Perpustakaan</small>
                    </div>
                @empty
                    <div class="p-5 text-center text-muted">
                        <i class="fas fa-inbox fs-1 mb-3 d-block"></i>
                        Belum ada pesan masuk untukmu.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection