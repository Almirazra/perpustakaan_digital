<?php

namespace App\Http\Controllers;
use App\Models\NotifikasiModel as Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $status = in_array($request->status, ['belum_dibaca', 'dibaca']) ? $request->status : null;

        $notifikasis = Notifikasi::with('siswa')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->get();

        return view('pages.notifikasi.index', [
            'notifikasis' => $notifikasis,
            'status'      => $status,
            'jumlahBelum' => Notifikasi::where('status', 'belum_dibaca')->count(),
        ]);
    }
     public function tandaiDibaca(Notifikasi $notifikasi): RedirectResponse
    {
        $notifikasi->tandaiDibaca();

        return back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }
    public function tandaiSemua(): RedirectResponse
    {
        $jumlah = Notifikasi::where('status', 'belum_dibaca')->update(['status' => 'dibaca']);

        return back()->with('success', "{$jumlah} notifikasi ditandai sudah dibaca");
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notifikasi $notifikasi): RedirectResponse
    {
        $notifikasi->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus');
    }
}
