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
    public function index()
    {
        // Kosongkan saja untuk proses register
    }

    public function create()
    {
        return view('auth.register'); 
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (NIS diubah jadi wajib numeric)
        $request->validate([
            'nis'          => ['required', 'numeric', 'digits_between:5,15', 'unique:siswas,nis'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'kelas'        => ['required', 'string', 'max:50'],
            'jurusan'      => ['required', 'string', 'max:50'],
            'no_telp'      => ['required', 'string', 'max:20'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nis.unique'         => 'NIS ini sudah pernah didaftarkan!',
            'nis.numeric'        => 'NIS hanya boleh berisi angka.',
            'nis.digits_between' => 'NIS harus berjumlah antara 5 hingga 15 angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        // 2. Mulai proses penyimpanan dengan DB Transaction
        DB::beginTransaction();

        try {
            // A. Simpan Akun ke tabel 'users'
            $user = User::create([
                'name'     => $request->nama_lengkap, 
                'email'    => $request->nis . '@siswa.perpus.test', // Ubah TLD menjadi .test (standar lokal)
                'role'     => 'siswa', // Mutlak di-set sebagai siswa
                'password' => Hash::make($request->password),
            ]);

            // B. Simpan Profil ke tabel 'siswas'
            SiswaModel::create([
                'nis'          => $request->nis,
                'nama_lengkap' => $request->nama_lengkap, 
                'kelas'        => $request->kelas,
                'telp'         => $request->no_telp,
                'jurusan'      => $request->jurusan,
            ]);

            // Simpan permanen ke database
            DB::commit();

            // 3. Ubah alur: Hapus auto-login dan arahkan kembali ke halaman login utama
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login menggunakan NIS atau email dan password kamu.');

        } catch (\Exception $e) {
            // Batalkan semua perubahan jika terjadi error
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}