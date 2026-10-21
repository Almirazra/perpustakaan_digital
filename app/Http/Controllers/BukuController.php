<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // --- KHUSUS HALAMAN KATALOG BUKU SISWA (Sesuai Wireframe Rancangan 3) ---
    public function katalogSiswa(Request $request)
    {
        $query = BukuModel::with('kategori');

        // 1. Pencarian berdasarkan Judul atau Pengarang
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->keyword . '%')
                  ->orWhere('pengarang', 'like', '%' . $request->keyword . '%');
            });
        }

        // 2. Filter Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Ambil data buku dengan pagination 6 items per halaman
        $buku = $query->latest()->paginate(6)->withQueryString();
        $kategori = KategoriModel::all();

        // 3. Menentukan Detail Buku yang tampil di panel kanan
        $detailBuku = null;
        if ($request->filled('detail_id')) {
            $detailBuku = BukuModel::with('kategori')->find($request->detail_id);
        } else {
            $detailBuku = $buku->first(); // Default menampilkan buku pertama
        }

        return view('siswa.buku.katalog_siswa', compact('buku', 'kategori', 'detailBuku'));
    }

    // --- METODE ADMIN / PETUGAS (Kode Kamu Sebelumnya) ---
    public function index()
    {
        $buku = BukuModel::with('kategori')->latest()->paginate(10);
        $kategori = KategoriModel::all();
        return view('pages.buku.index', compact('buku', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriModel::all();
        return view('pages.buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|max:255',
            'pengarang'    => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'stok'         => 'required|integer|min:0',
            'lokasi_rak'   => 'nullable|string|max:255',
        ]);

        BukuModel::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $buku = BukuModel::with('kategori')->findOrFail($id);
        return view('pages.buku.show', compact('buku'));
    }

    public function edit(string $id)
    {
        $buku = BukuModel::findOrFail($id);
        $kategori = KategoriModel::all();

        return view('pages.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|max:255',
            'pengarang'    => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'stok'         => 'required|integer|min:0',
            'lokasi_rak'   => 'nullable|string|max:255',
        ]);

        $buku = BukuModel::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $buku = BukuModel::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus!');
    }
}