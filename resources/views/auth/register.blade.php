@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register Siswa Baru') }}</div>

                    <div class="card-body">
                        
                        <!-- Alert Pesan Error -->
                        @if (session('error'))
                            <div class="alert alert-danger mb-3">
                                <strong>Gagal:</strong> {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger mb-3">
                                Pendaftaran gagal! Silakan cek tulisan warna merah di bawah kolom isian.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- NIS Input (Diubah jadi type="number") -->
                            <div class="row mb-3">
                                <label for="nis" class="col-md-4 col-form-label text-md-end">{{ __('NIS (Nomor Induk Siswa)') }}</label>

                                <div class="col-md-6">
                                    <input id="nis" type="number"
                                        class="form-control @error('nis') is-invalid @enderror" name="nis"
                                        value="{{ old('nis') }}" placeholder="Contoh: 19007" required autocomplete="nis" autofocus>

                                    @error('nis')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <span class="text-muted small d-block mt-1">*Hanya angka, tanpa tanda kurung atau garis miring.</span>
                                </div>
                            </div>

                            <!-- Nama Lengkap Input -->
                            <div class="row mb-3">
                                <label for="nama_lengkap" class="col-md-4 col-form-label text-md-end">{{ __('Nama Lengkap') }}</label>

                                <div class="col-md-6">
                                    <input id="nama_lengkap" type="text"
                                        class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap"
                                        value="{{ old('nama_lengkap') }}" placeholder="Masukan Nama Lengkap" required autocomplete="nama_lengkap">

                                    @error('nama_lengkap')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kelas Input -->
                            <div class="row mb-3">
                                <label for="kelas" class="col-md-4 col-form-label text-md-end">{{ __('Kelas') }}</label>

                                <div class="col-md-6">
                                    <!-- Rekomendasi: Ganti jadi Select Option, tapi pakai text input sesuai aslinya dulu -->
                                    <input id="kelas" type="text"
                                        class="form-control @error('kelas') is-invalid @enderror" name="kelas"
                                        value="{{ old('kelas') }}" placeholder="Contoh: X, XI, XII" required autocomplete="off">

                                    @error('kelas')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jurusan Input -->
                            <div class="row mb-3">
                                <label for="jurusan" class="col-md-4 col-form-label text-md-end">{{ __('Jurusan') }}</label>

                                <div class="col-md-6">
                                    <!-- Rekomendasi: Ganti jadi Select Option, tapi pakai text input sesuai aslinya dulu -->
                                    <input id="jurusan" type="text"
                                        class="form-control @error('jurusan') is-invalid @enderror" name="jurusan"
                                        value="{{ old('jurusan') }}" placeholder="Contoh: RPL, TKJ" required autocomplete="jurusan">

                                    @error('jurusan')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- No Telp Input -->
                            <div class="row mb-3">
                                <label for="no_telp" class="col-md-4 col-form-label text-md-end">{{ __('No Telepon/WA') }}</label>

                                <div class="col-md-6">
                                    <input id="no_telp" type="tel"
                                        class="form-control @error('no_telp') is-invalid @enderror" name="no_telp"
                                        value="{{ old('no_telp') }}" placeholder="Contoh: 081234567890" required autocomplete="tel">

                                    @error('no_telp')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Input -->
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Masukan Password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password Input -->
                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Konfirmasi Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" placeholder="Masukan Ulang Password" required autocomplete="new-password">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Daftar Sekarang') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection