<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiModel as Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiSiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Mengambil notifikasi berdasarkan siswa_id yang sama dengan id user yang login
        $notifikasis = Notifikasi::with('siswa')
            ->where('siswa_id', $user->id)
            ->latest()
            ->get();

        $jumlahBelum = Notifikasi::where('status', 'belum_dibaca')
            ->where('siswa_id', $user->id)
            ->count();

        return view('pages.siswa.notifikasi', [
            'notifikasis' => $notifikasis,
            'jumlahBelum' => $jumlahBelum,
        ]);
    }
}