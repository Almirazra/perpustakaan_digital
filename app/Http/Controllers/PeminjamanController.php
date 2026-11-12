<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanModel as PeminjamanModel;
use App\Models\SiswaModel;
use App\Models\BukuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Menampilkan daftar data peminjaman
    public function index()
    {
        $peminjamans = PeminjamanModel::with(['siswa', 'buku', 'pengembalian'])->latest()->get();
        return view('pages.peminjaman.index', compact('peminjamans'));
    }

    // Menampilkan form tambah peminjaman
    public function create()
    {
        $siswas = SiswaModel::all();
        $bukus = BukuModel::all();
        return view('pages.peminjaman.create', compact('siswas', 'bukus'));
    }

    // Menyimpan data peminjaman baru
    // Menyimpan data peminjaman baru
    // Menyimpan data peminjaman baru
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'buku_id'  => 'required',
            'jumlah'   => 'required|integer|min:1',
        ]);

        $buku = BukuModel::findOrFail($request->buku_id);

        if ($buku->stok < $request->jumlah) {
            return back()->withInput()->with('error', 'Stok buku tidak cukup. Sisa: ' . $buku->stok);
        }

        DB::transaction(function () use ($request, $buku)  {
            PeminjamanModel::create([
                'siswa_id' => $request->siswa_id,
                'buku_id' => $request->buku_id,
                'tanggal_peminjaman' => now(),
                'tanggal_kembali' => now()->addDays(config('perpustakaan.durasi_pinjam_hari')), // default 7 hari
                'jumlah' => $request->jumlah,
                'status' => 'dipinjam',
            ]);
            $buku->decrement('stok', $request->jumlah);
        });

        // Cek apakah yang login adalah siswa atau bukan
        $user = Auth::user();
        $siswaCek = SiswaModel::where('nama_lengkap', $user->name)->first();

        if ($siswaCek || $user->role === 'siswa') {
            // Jika siswa, arahkan langsung ke halaman "Peminjaman Aktif Saya"
            return redirect()->route('siswa.peminjaman.index')->with('success', 'Buku berhasil dipinjam!');
        }

        // Jika admin yang menambah, arahkan ke halaman kelola admin
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }
    // Proses pengembalian buku (mengubah status menjadi dikembalikan)


    // Menghapus data peminjaman
    public function destroy(int $id)
    {
        $peminjaman = PeminjamanModel::findOrFail($id);
        $peminjaman->delete();

        // Perhatikan bagian route ini disamakan ke 'peminjaman.index'
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

   public function peminjamanSiswa()
    {
        $user = Auth::user();
        
        // Memperbaiki pencarian siswa agar mencocokkan nama user yang login dengan nama_lengkap di tabel siswas
        $siswa = SiswaModel::where('nama_lengkap', $user->name)->first();

        $peminjamans = collect();
        $jatuhTempoTerdekat = null;
        $totalDenda = 0;

        if ($siswa) {
            $peminjamans = PeminjamanModel::with(['buku'])
                ->where('siswa_id', $siswa->id)
                ->where('status', 'dipinjam')
                ->orderBy('tanggal_kembali', 'asc')
                ->get();

            if ($peminjamans->isNotEmpty()) {
                $jatuhTempoTerdekat = $peminjamans->first()->tanggal_kembali;
            }

            $tarifDenda = config('perpustakaan.denda_per_hari', 1000);
            foreach ($peminjamans as $item) {
                if (now()->startOfDay()->gt($item->tanggal_kembali->startOfDay())) {
                    $hariTerlambat = $item->tanggal_kembali->startOfDay()->diffInDays(now()->startOfDay());
                    $item->estimasi_denda = $hariTerlambat * $tarifDenda * $item->jumlah;
                    $totalDenda += $item->estimasi_denda;
                } else {
                    $item->estimasi_denda = 0;
                }
            }
        }

        return view('pages.siswa_member.peminjaman', compact('peminjamans', 'jatuhTempoTerdekat', 'totalDenda'));
    }

    public function riwayatSiswa()
    {
        $user = Auth::user();
        $siswa = SiswaModel::where('nama_lengkap', $user->name)->first();

        $riwayats = collect();

        if ($siswa) {
            // Mengambil peminjaman milik siswa yang statusnya sudah dikembalikan / selain 'dipinjam'
            $riwayats = PeminjamanModel::with(['buku', 'pengembalian'])
                ->where('siswa_id', $siswa->id)
                ->where('status', '!=', 'dipinjam')
                ->latest()
                ->get();
        }

        return view('pages.siswa_member.riwayat', compact('riwayats'));
    }
}

