<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SiswaModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Kosongkan saja untuk proses register
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form register
        return view('auth.register'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (Ubah 'name' menjadi 'nama_lengkap')
        $request->validate([
            'nis'          => ['required', 'string', 'max:20', 'unique:siswas,nis'],
            'nama_lengkap' => ['required', 'string', 'max:255'], // <-- INI DIUBAH
            'kelas'        => ['required', 'string', 'max:50'],
            'jurusan'      => ['required', 'string', 'max:50'],
            'no_telp'      => ['required', 'string', 'max:20'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nis.unique'         => 'NIS ini sudah pernah didaftarkan!',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        // 2. Mulai proses penyimpanan dengan DB Transaction
        DB::beginTransaction();

        try {
            // A. Simpan Akun ke tabel 'users'
            $user = User::create([
                'name'     => $request->nama_lengkap, // <-- Ambil dari $request->nama_lengkap
                'email'    => $request->nis . '@siswa.perpus', 
                'role'     => 'siswa',
                'password' => Hash::make($request->password),
            ]);

            // B. Simpan Profil ke tabel 'siswas'
            SiswaModel::create([
                'nis'          => $request->nis,
                'nama_lengkap' => $request->nama_lengkap, // <-- Ambil dari $request->nama_lengkap
                'kelas'        => $request->kelas,
                'telp'         => $request->no_telp,
                'jurusan'      => $request->jurusan,
            ]);

            // Simpan permanen ke database
            DB::commit();

            // 3. Otomatis login
            Auth::login($user);

            // 4. Arahkan ke halaman beranda
            return redirect('/login')->with('success', 'Akun berhasil didaftarkan! Silakan login menggunakan NIS.');

        } catch (\Exception $e) {
            // Batalkan semua perubahan jika terjadi error
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}