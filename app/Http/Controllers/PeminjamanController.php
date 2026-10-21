<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanModel as PeminjamanModel;
use App\Models\SiswaModel;
use App\Models\BukuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // Perhatikan bagian route ini disamakan ke 'peminjaman.index'
        });

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
}
