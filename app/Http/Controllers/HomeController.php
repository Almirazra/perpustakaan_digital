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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 6 bulan terakhir untuk grafik batang
        $bulan = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->startOfMonth());

        $grafikBulanan = [
            'labels'       => $bulan->map(fn ($b) => $b->translatedFormat('M Y'))->all(),
            'data' => $bulan->map(fn ($b) => Peminjaman::whereBetween('tanggal_peminjaman', [$b, $b->copy()->endOfMonth()])->count())->all(),
        ];


        return view('home', [
            'totalBuku'       => Buku::count(),
            'totalSiswa'      => Siswa::count(),
            'sedangDipinjam'  => Peminjaman::where('status', 'dipinjam')->count(),
            'totalDenda'      => Denda::sum('jumlah'),
            'totalPeminjaman' => Peminjaman::count(),
            'totalPengembalian' => Pengembalian::count(),
            'dendaBelumBayar' => Denda::where('status_bayar', 'belum_bayar')->sum('jumlah'),
            'daftarDenda' => Denda::with(['pengembalian.peminjaman.siswa', 'pengembalian.peminjaman.buku'])
                            ->where('status_bayar', 'belum_bayar')
                            ->latest()
                            ->take(5)
                            ->get(),
            'transaksiTerbaru' => Peminjaman::with(['siswa', 'buku'])->latest()->take(5)->get(),
            'grafikBulanan'   => $grafikBulanan,


            // Aktivitas hanya diambil untuk admin
            'aktivitas' => Auth::user()->role === 'admin'
                ? ActivityLog::with('user')->latest()->take(8)->get()
                : collect(),

            // Pengingat: masih dipinjam dan sudah lewat jatuh tempo
            'terlambat' => Peminjaman::with(['siswa', 'buku'])
                ->where('status', 'dipinjam')
                ->whereDate('tanggal_kembali', '<', today())
                ->orderBy('tanggal_kembali')
                ->get(),
        ]);
    }
}
