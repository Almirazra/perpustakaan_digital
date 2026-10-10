<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanModel as PeminjamanModel;
use App\Models\PengembalianModel as PengembalianModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    // Menampilkan daftar riwayat pengembalian buku
    public function index()
    {
        $pengembalians = PengembalianModel::with(['peminjaman.siswa', 'peminjaman.buku'])->latest()->get();
        return view('pages.pengembalian.index', compact('pengembalians'));
    }

    // Memproses pengembalian buku dari data peminjaman
    public function store(Request $request, $peminjaman_id)
    {
        $peminjaman = PeminjamanModel::findOrFail($peminjaman_id);

        // Pastikan buku belum dikembalikan sebelumnya
        if ($peminjaman->status == 'dikembalikan') {
            return redirect()->back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        // Tanggal pengembalian hari ini (atau dari request jika ada input khusus)
        $tanggalPengembalian = Carbon::now();
        $tanggalJatuhTempo = Carbon::parse($peminjaman->tanggal_kembali);

        $keterlambatan = 0;
        $denda = 0;
        $status = 'tepat_waktu';

        // Cek apakah terlambat (jika tanggal pengembalian > tanggal jatuh tempo)
        if ($tanggalPengembalian->greaterThan($tanggalJatuhTempo)) {
            $keterlambatan = $tanggalJatuhTempo->diffInDays($tanggalPengembalian);

            // Contoh tarif denda: Rp 1.000 per hari keterlambatan (bisa disesuaikan aturan perpustakaanmu)
            $tarifDendaPerHari = 1000;
            $denda = $keterlambatan * $tarifDendaPerHari;
            $status = 'terlambat';
        }

        // Simpan data ke tabel pengembalians
        PengembalianModel::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_pengembalian' => $tanggalPengembalian->toDateString(),
            'keterlambatan' => $keterlambatan,
            'denda' => $denda,
            'status' => $status,
        ]);

        // Update status di tabel peminjamans menjadi 'dikembalikan'
        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Buku berhasil dikembalikan. Keterlambatan: ' . $keterlambatan . ' hari, Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }

    // Menghapus data riwayat pengembalian
    public function destroy($id)
    {
        $pengembalian = PengembalianModel::findOrFail($id);

        // Kembalikan status peminjamannya ke 'dipinjam' jika riwayat pengembalian dihapus
        $pengembalian->peminjaman->update([
            'status' => 'dipinjam'
        ]);

        $pengembalian->delete();

        return redirect()->route('pengembalian.index')->with('success', 'Riwayat pengembalian berhasil dihapus.');
    }
}
