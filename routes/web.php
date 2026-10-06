<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman awal: langsung ke login
Route::redirect('/', '/login');

// Login & logout saja (register dan reset password dimatikan)
Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

// Semua halaman di bawah ini wajib login
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Aktifkan satu per satu setelah file Blade-nya dibuat
    Route::view('/buku', 'buku');
    // Route::view('/kategori', 'kategori');
    // Route::view('/siswa', 'siswa');
    // Route::view('/peminjaman', 'peminjaman');
    // Route::view('/pengembalian', 'pengembalian');
    // Route::view('/denda', 'denda');
    // Route::view('/notifikasi', 'notifikasi');
});
