<?php

namespace Database\Seeders;
use App\Models\KategoriModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $data = [
        ['nama_kategori' => 'Fiksi',     'keterangan' => 'Novel, cerpen, dan karya fiksi lainnya'],
        ['nama_kategori' => 'Sains',     'keterangan' => 'Buku fisika, kimia, biologi, dan matematika'],
        ['nama_kategori' => 'Teknologi', 'keterangan' => 'Buku pemrograman dan komputer'],
        ['nama_kategori' => 'Sejarah',   'keterangan' => 'Buku sejarah Indonesia dan dunia'],
        ['nama_kategori' => 'Pelajaran', 'keterangan' => 'Buku paket pelajaran sekolah'],
    ];

    foreach ($data as $item) {
        KategoriModel::updateOrCreate(['nama_kategori' => $item['nama_kategori']], $item);
    }
}
}
