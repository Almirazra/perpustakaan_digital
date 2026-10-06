<?php

namespace Database\Seeders;

use App\Models\{BukuModel, DendaModel, NotifikasiModel, PeminjamanModel, PengembalianModel, SiswaModel};
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = SiswaModel::all();
        $buku  = BukuModel::all();

        // 1. Masih dipinjam
        PeminjamanModel::create([
            'siswa_id' => $siswa[0]->id, 'buku_id' => $buku[0]->id,
            'tanggal_peminjaman' => now()->subDays(3), 'tanggal_kembali' => now()->addDays(4),
            'jumlah' => 1, 'status' => 'dipinjam',
        ]);

        // 2. Dikembalikan tepat waktu
        $p2 = PeminjamanModel::create([
            'siswa_id' => $siswa[1]->id, 'buku_id' => $buku[2]->id,
            'tanggal_peminjaman' => now()->subDays(10), 'tanggal_kembali' => now()->subDays(3),
            'jumlah' => 1, 'status' => 'dikembalikan',
        ]);
        PengembalianModel::create([
            'peminjaman_id' => $p2->id, 'tanggal_pengembalian' => now()->subDays(4),
            'keterlambatan' => 0, 'denda' => 0, 'status' => 'tepat_waktu',
        ]);

        // 3. Dikembalikan terlambat -> kena denda
        $p3 = PeminjamanModel::create([
            'siswa_id' => $siswa[2]->id, 'buku_id' => $buku[3]->id,
            'tanggal_peminjaman' => now()->subDays(20), 'tanggal_kembali' => now()->subDays(13),
            'jumlah' => 1, 'status' => 'dikembalikan',
        ]);
        $k3 = PengembalianModel::create([
            'peminjaman_id' => $p3->id, 'tanggal_pengembalian' => now()->subDays(10),
            'keterlambatan' => 3, 'denda' => 3000, 'status' => 'terlambat',
        ]);
        DendaModel::create([
            'pengembalian_id' => $k3->id, 'jumlah' => 3000,
            'keterangan' => 'Terlambat 3 hari', 'status_bayar' => 'belum_bayar',
        ]);

        NotifikasiModel::kirim($siswa[0]->id, 'Peminjaman Berhasil', 'Anda meminjam buku Laskar Pelangi.');
        NotifikasiModel::kirim($siswa[2]->id, 'Denda Keterlambatan', 'Anda memiliki denda sebesar Rp3.000.');
    }
}