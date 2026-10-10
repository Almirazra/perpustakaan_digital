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

Route::redirect('/', '/login');

Auth::routes([
    'register' => false,
    'reset'    => false,
    'verify'   => false,
    'confirm'  => false,

]);

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::resource('buku', BukuController::class);

    // Route kartu harus di atas resource siswa, kalau tidak "kartu" dianggap ID siswa
    Route::get('siswa/kartu', [SiswaController::class, 'kartuSemua'])->name('siswa.kartu.semua');
    Route::get('siswa/{siswa}/kartu', [SiswaController::class, 'kartu'])->name('siswa.kartu');
    Route::resource('siswa', SiswaController::class);

    Route::resource('peminjaman', PeminjamanController::class)
        ->only(['index', 'create', 'store', 'destroy'])
        ->parameters(['peminjaman' => 'peminjaman']);
    Route::put('peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');

    // Aktifkan setelah controller web dan Blade-nya dibuat:
    Route::get('pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('pengembalian/{peminjaman}/store', [PengembalianController::class, 'store'])->name('pengembalian.store');
    Route::resource('denda', DendaController::class)
    ->only(['index', 'update'])
    ->parameters(['denda' => 'denda']);
    Route::patch('notifikasi/dibaca-semua', [NotifikasiController::class, 'tandaiSemua'])->name('notifikasi.dibaca-semua');
    Route::patch('notifikasi/{notifikasi}/dibaca', [NotifikasiController::class, 'tandaiDibaca'])->name('notifikasi.dibaca');
    Route::resource('notifikasi', NotifikasiController::class)
    ->only(['index', 'destroy'])
    ->parameters(['notifikasi' => 'notifikasi']);
    // Route::resource('notifikasi', NotifikasiController::class)->only(['index', 'destroy']);
    // Route::patch('notifikasi/{notifikasi}/dibaca', [NotifikasiController::class, 'tandaiDibaca'])->name('notifikasi.dibaca');
});
