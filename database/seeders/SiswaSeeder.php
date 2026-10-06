<?php

namespace Database\Seeders;
use App\Models\SiswaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
        SiswaModel::updateOrCreate(['nis' => $item['nis']], $item);
    }
}
}
