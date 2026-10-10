<?php

namespace App\Http\Controllers;
use App\Models\DendaModel as Denda;
use App\Models\NotifikasiModel as Notifikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        $status = in_array($request->status, ['belum_bayar', 'lunas']) ? $request->status : null;

        $dendas = Denda::with(['pengembalian.peminjaman.siswa', 'pengembalian.peminjaman.buku'])
            ->when($status, fn ($q) => $q->where('status_bayar', $status))
            ->latest()
            ->get();

        return view('pages.denda.index', [
            'dendas'      => $dendas,
            'status'      => $status,
            'totalBelum'  => Denda::where('status_bayar', 'belum_bayar')->sum('jumlah'),
            'totalLunas'  => Denda::where('status_bayar', 'lunas')->sum('jumlah'),
            'jumlahBelum' => Denda::where('status_bayar', 'belum_bayar')->count(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Denda $denda)
    {
        $data = $request->validate([
            'status_bayar' => 'required|in:belum_bayar,lunas',
        ]);

        if ($denda->status_bayar === $data['status_bayar']) {
            return back()->with('error', 'Status denda tidak berubah');
        }

        // Membatalkan pelunasan berarti mengubah uang yang sudah diterima, jadi khusus admin
        if ($data['status_bayar'] === 'belum_bayar') {
            abort_unless($request->user()->role === 'admin', 403, 'Hanya admin yang boleh membatalkan pelunasan');
        }

        $denda->update($data);

        if ($data['status_bayar'] === 'lunas') {
            $siswa = $denda->pengembalian->peminjaman->siswa;

            Notifikasi::kirim(
                $siswa->id,
                'Denda lunas',
                'Denda sebesar Rp' . number_format($denda->jumlah, 0, ',', '.') . ' sudah tercatat lunas. Terima kasih.'
            );

            return back()->with('success', "Denda {$siswa->nama_lengkap} ditandai lunas");
        }

        return back()->with('success', 'Pelunasan denda dibatalkan');
    }
    }
