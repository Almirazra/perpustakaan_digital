<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiModel as Notifikasi;
use App\Models\SiswaModel as Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource (Admin).
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

    /**
     * Display a listing of notifications for logged in student.
     */
    public function indexSiswa()
    {
        $user = Auth::user();
        $nis = explode('@', $user->email)[0];
        $siswa = Siswa::where('nis', $nis)->first();

        $notifikasis = collect();

        if ($siswa) {
            $notifikasis = Notifikasi::with('siswa')
                            ->where('siswa_id', $siswa->id)
                            ->latest()
                            ->get();

            Notifikasi::where('siswa_id', $siswa->id)
                ->where('status', 'belum_dibaca')
                ->update(['status' => 'dibaca']);
        }

        $jumlahBelum = $siswa
            ? Notifikasi::where('siswa_id', $siswa->id)->where('status', 'belum_dibaca')->count()
            : 0;

        // ARAHKAN KE VIEW KHUSUS KOTAK MASUK SISWA
        return view('pages.notifikasi.index', compact('notifikasis', 'jumlahBelum'));
    }
    public function tandaiSemua(): RedirectResponse
    {
        $jumlah = Notifikasi::where('status', 'belum_dibaca')->update(['status' => 'dibaca']);

        return back()->with('success', "{$jumlah} notifikasi ditandai sudah dibaca");
    }

    public function create()
    {
        $siswas = Siswa::all();

        return view('pages.notifikasi.create', compact('siswas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'judul'   => 'required|string|max:255',
            'pesan'   => 'required|string',
        ]);

        Notifikasi::create([
            'siswa_id' => $request->siswa_id,
            'judul'   => $request->judul,
            'pesan'   => $request->pesan,
            'status'  => 'belum_dibaca',
        ]);

        return redirect()->route('notifikasi.index')->with('success', 'Notifikasi berhasil dikirim ke siswa.');
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
