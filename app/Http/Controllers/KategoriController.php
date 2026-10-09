<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel as Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('bukus')->orderBy('nama_kategori')->get();

        return view('pages.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('pages.kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'keterangan'    => 'nullable|string',
        ], $this->pesan());

        Kategori::create($data);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategori $kategori)
    {
        return view('pages.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', Rule::unique('kategoris', 'nama_kategori')->ignore($kategori->id)],
            'keterangan'    => 'nullable|string',
        ], $this->pesan());

        $kategori->update($data);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        // Tabel bukus memakai cascadeOnDelete, jadi tanpa pengecekan ini semua buku ikut terhapus
        if ($kategori->bukus()->exists()) {
            return redirect()->route('kategori.index')
                ->with('error', "Kategori \"{$kategori->nama_kategori}\" masih dipakai {$kategori->bukus()->count()} buku, jadi tidak bisa dihapus");
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }

    private function pesan(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique'   => 'Nama kategori sudah ada',
            'nama_kategori.max'      => 'Nama kategori maksimal 255 karakter',
        ];
    }
}
