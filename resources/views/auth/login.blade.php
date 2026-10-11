@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-sm-8 col-12">

            <!-- Bagian Judul -->
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark" style="font-weight: 800;">Perpustakaan Digital</h2>
                <p class="text-dark">Silakan login untuk melanjutkan</p>
            </div>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Input NIS / Email -->
                <div class="mb-4">
                    <label for="email" class="form-label fw-bold text-dark">{{ __('NIS / Email') }}</label>
                    {{-- type="text" digunakan agar bisa menerima angka (NIS) atau teks (Email) --}}
                    <input id="email" type="text"
                        class="form-control border-dark rounded-0 py-2 @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" placeholder="Masukkan NIS (siswa) atau email (admin)" required
                        autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Input Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold text-dark">{{ __('Password') }}</label>
                    <div class="input-group">
                        <input id="password" type="password"
                            class="form-control border-dark rounded-0 py-2 border-end-0 @error('password') is-invalid @enderror"
                            name="password" placeholder="Masukkan password" required autocomplete="current-password">

                        <!-- Tombol "Lihat" Password -->
                        <span class="input-group-text bg-white border-dark rounded-0 border-start-0" id="togglePassword"
                            style="cursor: pointer;">
                            <span class="text-dark" style="font-size: 0.85rem; font-weight: 500;">Lihat</span>
                        </span>
                    </div>

                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Checkbox Ingat Saya -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input border-dark rounded-0" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-dark" for="remember">
                            {{ __('Ingat saya') }}
                        </label>
                    </div>
                </div>

                <!-- Tombol Login -->
                <div class="mb-3">
                    <button type="submit" class="btn w-100 rounded-0 fw-bold py-2 text-white"
                        style="background-color: black; border: 2px solid black;">
                        {{ __('LOGIN') }}
                    </button>
                </div>

                <!-- Link Pendaftaran -->
                <div class="text-center mt-4" style="font-size: 0.9rem;">
                    {{-- Pastikan route 'register' tersedia di project Anda --}}
                    <span class="text-dark">belum punya kartu anggota? </span>
                    <a href="{{ route('register') }}" class="text-blue text-decoration-none">
                        daftar disini
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tambahan Script untuk fitur "Lihat" Password -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.querySelector("#togglePassword");
            const password = document.querySelector("#password");

            togglePassword.addEventListener("click", function() {
                // Toggle type attribute
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);

                // Toggle text
                this.querySelector("span").textContent = type === "password" ? "Lihat" : "Tutup";
            });
        });
    </script>
@endsection
