@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 fs-4 mb-2"><i class="fas fa-envelope me-2"></i> Pesan Masuk</h1>
    <ol class="breadcrumb mb-3 small">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pesan Masuk</li>
    </ol>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center border-bottom">
            <span class="fw-bold small text-dark"><i class="fas fa-bell me-1 text-secondary"></i> Daftar Pesan dari Admin</span>
            <a href="{{ route('home') }}" class="btn btn-sm btn-secondary py-1 px-2" style="font-size: 0.75rem;">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
        <div class="card-body p-3 bg-light">
            @forelse($notifikasis as $notif)
                <div class="card mb-2 shadow-sm border-0 {{ $notif->status === 'belum_dibaca' ? 'border-start border-primary border-4 bg-white' : 'bg-white' }}" style="border-radius: 6px;">
                    <div class="card-body py-2 px-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">
                                {{ $notif->judul }}
                                @if($notif->status === 'belum_dibaca')
                                    <span class="badge bg-primary ms-1" style="font-size: 0.6rem;">Baru</span>
                                @endif
                            </h6>
                            <span class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-clock me-1"></i> {{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-secondary mb-0" style="font-size: 0.825rem;">{{ $notif->pesan }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-muted small bg-white rounded shadow-sm">
                    <i class="fas fa-inbox fa-2x mb-2 text-secondary"></i>
                    <p class="mb-0">Belum ada pesan masuk untukmu.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
