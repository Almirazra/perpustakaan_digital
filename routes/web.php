<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\NotifikasiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\NotifikasiSiswaController;

Route::redirect('/', '/login');

Auth::routes([
    'register' => false,
    'reset'    => false,
    'verify'   => false,
    'confirm'  => false,
]);

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::resource('buku', BukuController::class);

    // --- RUTE SISWA (DITARUH DI ATAS SEBELUM RESOURCE SISWA) ---
    Route::get('/siswa/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');

    Route::get('/siswa/buku', [BukuController::class, 'katalogSiswa'])->name('siswa.buku.index');
    Route::get('/siswa/notifikasi', [NotifikasiController::class, 'indexSiswa'])->name('siswa.notifikasi.index');

    // Rute kartu dan resource siswa di bawahnya
    Route::get('siswa/kartu', [SiswaController::class, 'kartuSemua'])->name('siswa.kartu.semua');
    Route::get('siswa/{siswa}/kartu', [SiswaController::class, 'kartu'])->name('siswa.kartu');
    Route::resource('siswa', SiswaController::class);

    Route::resource('peminjaman', PeminjamanController::class)
        ->only(['index', 'create', 'store', 'destroy'])
        ->parameters(['peminjaman' => 'peminjaman']);

    Route::get('pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('pengembalian/{peminjaman}/store', [PengembalianController::class, 'store'])->name('pengembalian.store');

    Route::resource('denda', DendaController::class)
        ->only(['index', 'update'])
        ->parameters(['denda' => 'denda']);

    Route::patch('notifikasi/dibaca-semua', [NotifikasiController::class, 'tandaiSemua'])->name('notifikasi.dibaca-semua');
    Route::patch('notifikasi/{notifikasi}/dibaca', [NotifikasiController::class, 'tandaiDibaca'])->name('notifikasi.dibaca');
    Route::get('/admin/notifikasi/create', [App\Http\Controllers\NotifikasiController::class, 'create'])->name('notifikasi.create');
    Route::post('/admin/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'store'])->name('notifikasi.store');
    Route::resource('notifikasi', NotifikasiController::class)
        ->only(['index', 'destroy'])
        ->parameters(['notifikasi' => 'notifikasi']);
});
