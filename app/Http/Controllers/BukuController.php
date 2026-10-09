<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = BukuModel::with('kategori')->latest()->paginate(10);
        $kategori = KategoriModel::all();
        return view('pages.buku.index', compact('buku', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil semua data kategori untuk pilihan dropdown
        $kategori = KategoriModel::all();
        return view('pages.buku.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = BukuModel::with('kategori')->findOrFail($id);
        return view('pages.buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = BukuModel::findOrFail($id);
        $kategori = KategoriModel::all();

        return view('pages.buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = BukuModel::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus!');
    }
}
