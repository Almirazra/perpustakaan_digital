<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Auth::routes([
    'register' => false,
    'reset'    => false,
    'verify'   => false,
    'confirm'  => false,
]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Halaman memakai modal, jadi form create/edit/show tidak diperlukan
    Route::resource('kategori', KategoriController::class)->except(['show']);

    // Aktifkan satu per satu setelah controller web dan Blade-nya dibuat
   Route::resource('buku', BukuController::class);
    // Route::resource('siswa', SiswaController::class)->except(['create', 'edit', 'show']);
    // Route::resource('peminjaman', PeminjamanController::class)->only(['index', 'store', 'update']);
    // Route::resource('pengembalian', PengembalianController::class)->only(['index', 'store', 'update']);
    // Route::resource('denda', DendaController::class)->only(['index', 'update']);
    // Route::resource('notifikasi', NotifikasiController::class)->only(['index', 'destroy']);
    // Route::patch('notifikasi/{notifikasi}/dibaca', [NotifikasiController::class, 'tandaiDibaca'])->name('notifikasi.dibaca');

    // Route Peminjaman (dilindungi middleware auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::put('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

// Route Pengembalian
Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
Route::post('/pengembalian/{peminjaman_id}', [PengembalianController::class, 'store'])->name('pengembalian.store');
Route::delete('/pengembalian/{id}', [PengembalianController::class, 'destroy'])->name('pengembalian.destroy');
});
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
