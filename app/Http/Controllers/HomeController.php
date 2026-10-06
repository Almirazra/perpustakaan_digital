<?php

namespace App\Http\Controllers;

use App\Models\BukuModel as Buku;
use App\Models\DendaModel as Denda;
use App\Models\PeminjamanModel as Peminjaman;
use App\Models\SiswaModel as Siswa;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'totalBuku'      => Buku::count(),
            'totalSiswa'     => Siswa::count(),
            'sedangDipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'dendaBelumBayar'=> Denda::where('status_bayar', 'belum_bayar')->sum('jumlah'),
            'terbaru'        => Peminjaman::with(['siswa', 'buku'])->latest()->take(5)->get(),
        ]);
    }
}
