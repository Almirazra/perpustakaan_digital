<?php

namespace Database\Seeders;

use App\Models\SiswaModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nis' => '2024001', 'nama_lengkap' => 'Ahmad Fauzi',    'kelas' => 'X',   'jurusan' => 'RPL', 'telp' => '081234567801'],
            ['nis' => '2024002', 'nama_lengkap' => 'Siti Aisyah',    'kelas' => 'X',   'jurusan' => 'TKJ', 'telp' => '081234567802'],
            ['nis' => '2023003', 'nama_lengkap' => 'Rizky Ramadhan', 'kelas' => 'XI',  'jurusan' => 'RPL', 'telp' => '081234567803'],
            ['nis' => '2023004', 'nama_lengkap' => 'Dewi Lestari',   'kelas' => 'XI',  'jurusan' => 'AKL', 'telp' => '081234567804'],
            ['nis' => '2022005', 'nama_lengkap' => 'Budi Santoso',   'kelas' => 'XII', 'jurusan' => 'TKJ', 'telp' => '081234567805'],
        ];

        foreach ($data as $item) {
            // 1. Buat atau update data di tabel siswas
            SiswaModel::updateOrCreate(['nis' => $item['nis']], $item);

            // 2. Buat atau update akun di tabel users
            User::updateOrCreate(
                ['email' => $item['nis'] . '@siswa.perpus.test'], // Format email valid menggunakan NIS
                [
                    'name' => $item['nama_lengkap'],
                    'role' => 'siswa', // Hardcode role agar tidak bocor menjadi petugas
                    'password' => Hash::make('password123'), // Enkripsi password
                ]
            );
        }
    }
}