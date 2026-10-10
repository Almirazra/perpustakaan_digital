<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanModel;
use App\Models\SiswaModel;
use App\Models\BukuModel;
use Illuminate\Http\Request;

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
            'buku_id' => 'required',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_peminjaman',
            'jumlah' => 'required|integer|min:1',
        ]);

        PeminjamanModel::create([
            'siswa_id' => $request->siswa_id,
            'buku_id' => $request->buku_id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jumlah' => $request->jumlah,
            'status' => 'dipinjam',
        ]);

        // Perhatikan bagian route ini disamakan ke 'peminjamen.index'
        return redirect()->route('peminjamen.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    // Proses pengembalian buku (mengubah status menjadi dikembalikan)
    public function kembalikan($id)
    {
        $peminjaman = PeminjamanModel::findOrFail($id);
        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    }

    // Menghapus data peminjaman
    public function destroy($id)
    {
        $peminjaman = PeminjamanModel::findOrFail($id);
        $peminjaman->delete();

        // Perhatikan bagian route ini disamakan ke 'peminjamen.index'
        return redirect()->route('peminjamen.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}