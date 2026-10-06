<?php

namespace Database\Seeders;
use App\Models\BukuModel;
use App\Models\KategoriModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $kat = KategoriModel::pluck('id', 'nama_kategori');

    $data = [
        ['kategori_id' => $kat['Fiksi'],     'judul' => 'Laskar Pelangi',   'pengarang' => 'Andrea Hirata',   'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2005, 'stok' => 10, 'lokasi_rak' => 'A-01'],
        ['kategori_id' => $kat['Fiksi'],     'judul' => 'Bumi Manusia',     'pengarang' => 'Pramoedya A. T.', 'penerbit' => 'Hasta Mitra',     'tahun_terbit' => 1980, 'stok' => 6,  'lokasi_rak' => 'A-02'],
        ['kategori_id' => $kat['Sains'],     'judul' => 'Fisika Dasar',     'pengarang' => 'Halliday',        'penerbit' => 'Erlangga',        'tahun_terbit' => 2010, 'stok' => 8,  'lokasi_rak' => 'B-01'],
        ['kategori_id' => $kat['Teknologi'], 'judul' => 'Pemrograman Web dengan Laravel', 'pengarang' => 'Budi Raharjo', 'penerbit' => 'Informatika', 'tahun_terbit' => 2022, 'stok' => 5, 'lokasi_rak' => 'C-01'],
        ['kategori_id' => $kat['Sejarah'],   'judul' => 'Sejarah Indonesia Modern', 'pengarang' => 'M. C. Ricklefs', 'penerbit' => 'Serambi', 'tahun_terbit' => 2008, 'stok' => 4, 'lokasi_rak' => 'D-01'],
        ['kategori_id' => $kat['Pelajaran'], 'judul' => 'Matematika Kelas X', 'pengarang' => 'Kemendikbud',   'penerbit' => 'Kemendikbud',     'tahun_terbit' => 2021, 'stok' => 20, 'lokasi_rak' => 'E-01'],
    ];

    foreach ($data as $item) {
        BukuModel::updateOrCreate(['judul' => $item['judul']], $item);
    }
}
}
