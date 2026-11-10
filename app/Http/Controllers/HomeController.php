<?php

namespace App\Http\Controllers;

use App\Models\BukuModel as Buku;
use App\Models\PeminjamanModel as Peminjaman;
use App\Models\PengembalianModel as Pengembalian;
use App\Models\SiswaModel as Siswa;
use App\Models\DendaModel as Denda;
use App\Models\ActivityLog as ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // =========================================================
        // 1. LOGIKA UNTUK DASHBOARD SISWA
        // =========================================================
        if ($user->role === 'siswa') {
            $nis = explode('@', $user->email)[0];
            $siswa = Siswa::where('nis', $nis)->first();

            if ($siswa) {
                $peminjamanAktif = Peminjaman::with('buku')
                    ->where('siswa_id', $siswa->id)
                    ->where('status', 'dipinjam')
                    ->get();

                $totalDipinjam = $peminjamanAktif->count() . ' buku';
                
                $jatuhTempo = $peminjamanAktif->sortBy('tanggal_kembali')->first();
                $jatuhTempoTerdekat = $jatuhTempo ? Carbon::parse($jatuhTempo->tanggal_kembali)->format('d M Y') : '-';

                $totalDenda = 0;
            } else {
                $peminjamanAktif = collect();
                $totalDipinjam = '0 buku';
                $jatuhTempoTerdekat = '-';
                $totalDenda = 0;
            }

            // UBAH DI SINI: Ganti 'dashboard' menjadi 'home'
            return view('home', [
                'totalDipinjam'      => $totalDipinjam,
                'jatuhTempoTerdekat' => $jatuhTempoTerdekat,
                'totalDenda'         => $totalDenda,
                'peminjamanAktif'    => $peminjamanAktif,
                'notifikasiSiswa'    => [] // Menyesuaikan nama variabel dengan file view kita
            ]);
        }

        // =========================================================
        // 2. LOGIKA UNTUK DASHBOARD ADMIN & PETUGAS
        // =========================================================
        $bulan = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->startOfMonth());

        $grafikBulanan = [
            'labels' => $bulan->map(fn ($b) => $b->translatedFormat('M Y'))->all(),
            'data'   => $bulan->map(fn ($b) => Peminjaman::whereBetween('tanggal_peminjaman', [$b, $b->copy()->endOfMonth()])->count())->all(),
        ];

        return view('home', [
            'totalBuku'         => Buku::count(),
            'totalSiswa'        => Siswa::count(),
            'sedangDipinjam'    => Peminjaman::where('status', 'dipinjam')->count(),
            'totalDendaAdmin'   => Denda::sum('jumlah'), // Menyesuaikan nama variabel dengan file view kita
            'totalPeminjaman'   => Peminjaman::count(),
            'totalPengembalian' => Pengembalian::count(),
            'dendaBelumBayar'   => Denda::where('status_bayar', 'belum_bayar')->sum('jumlah'),
            'daftarDenda'       => Denda::with(['pengembalian.peminjaman.siswa', 'pengembalian.peminjaman.buku'])
                                    ->where('status_bayar', 'belum_bayar')
                                    ->latest()
                                    ->take(5)
                                    ->get(),
            'transaksiTerbaru'  => Peminjaman::with(['siswa', 'buku'])->latest()->take(5)->get(),
            'grafikBulanan'     => $grafikBulanan,
            'aktivitas'         => $user->role === 'admin'
                                    ? ActivityLog::with('user')->latest()->take(8)->get()
                                    : collect(),
            'terlambat'         => Peminjaman::with(['siswa', 'buku'])
                                    ->where('status', 'dipinjam')
                                    ->whereDate('tanggal_kembali', '<', today())
                                    ->orderBy('tanggal_kembali')
                                    ->get(),
        ]);
    }
}