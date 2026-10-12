@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        
                        <!-- KODE PENAMPIL ERROR DITAMBAHKAN DI SINI -->
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
                        <!-- BATAS KODE PENAMPIL ERROR -->

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="nis" class="col-md-6 offset-md-4 form-label">{{ __('NIS') }}</label>

                                <div class="col-md-6 offset-md-4">
                                    <input id="nis" type="text"
                                        class="form-control @error('nis') is-invalid @enderror" name="nis"
                                        value="{{ old('nis') }}" placeholder="Masukan NIS" required autocomplete="nis" autofocus>

                                    @error('nis')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <span class="text-black small d-block mt-1">Tambahkan tahun ajaran (misal: 2024/2025)</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nama_lengkap" class="col-md-6 offset-md-4 form-label">{{ __('Name') }}</label>

                                <div class="col-md-6 offset-md-4">
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

                            <div class="row mb-3">
                                <label for="kelas" class="col-md-6 offset-md-4 form-label">{{ __('Kelas') }}</label>

                                <div class="col-md-6 offset-md-4">
                                    <input id="kelas" type="text"
                                        class="form-control @error('kelas') is-invalid @enderror" name="kelas"
                                        value="{{ old('kelas') }}" placeholder="Masukan Kelas" required autocomplete="off">

                                    @error('kelas')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jurusan" class="col-md-6 offset-md-4 form-label">{{ __('Jurusan') }}</label>

                                <div class="col-md-6 offset-md-4">
                                    <input id="jurusan" type="text"
                                        class="form-control @error('jurusan') is-invalid @enderror" name="jurusan"
                                        value="{{ old('jurusan') }}" placeholder="Masukan Jurusan (misal: RPL, TKJ)" required autocomplete="jurusan">

                                    @error('jurusan')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="no_telp" class="col-md-6 offset-md-4 form-label">{{ __('No Telp') }}</label>

                                <div class="col-md-6 offset-md-4">
                                    <input id="no_telp" type="tel"
                                        class="form-control @error('no_telp') is-invalid @enderror" name="no_telp"
                                        value="{{ old('no_telp') }}" placeholder="Masukan No Telp" required autocomplete="tel">

                                    @error('no_telp')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-6 offset-md-4 form-label">{{ __('Password') }}</label>

                                <div class="col-md-6 offset-md-4">
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

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-6 offset-md-4 form-label">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6 offset-md-4">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" placeholder="Masukan Konfirmasi Password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
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