<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // --- KHUSUS HALAMAN KATALOG BUKU SISWA ---
    public function katalogSiswa(Request $request)
    {
        $query = BukuModel::with('kategori');

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->keyword . '%')
                  ->orWhere('pengarang', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $buku = $query->latest()->paginate(6)->withQueryString(); 
        $kategori = KategoriModel::all();

        // Menentukan Detail Buku yang tampil di panel kanan
        $detailBuku = null;
        if ($request->filled('detail_id')) {
            $detailBuku = BukuModel::with('kategori')->find($request->detail_id);
        } else {
            $detailBuku = $buku->first(); 
        }

        return view('pages.siswa.buku.katalog_siswa', compact('buku', 'kategori', 'detailBuku'));
    }

    // --- HALAMAN DETAIL BUKU SISWA (Terpisah) ---
    public function showSiswa($id)
    {
        $buku = BukuModel::with('kategori')->findOrFail($id);

        return view('pages.siswa.buku_detail', compact('buku'));
    }

    // --- METODE ADMIN / PETUGAS ---
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
            'sinopsis'     => 'nullable|string',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        BukuModel::create($data);

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
            'sinopsis'     => 'nullable|string',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
        ]);

        $buku = BukuModel::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada file baru di-upload
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $buku = BukuModel::findOrFail($id);

        // Hapus file cover fisik jika ada saat buku dihapus
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus!');
    }
}