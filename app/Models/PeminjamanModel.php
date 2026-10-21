<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\MencatatAktivitas;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PeminjamanModel extends Model
{
    use MencatatAktivitas;

    protected $table = 'peminjamans';

    protected $fillable = [
        'siswa_id', 'buku_id', 'tanggal_peminjaman',
        'tanggal_kembali', 'jumlah', 'status',
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'datetime',
        'tanggal_kembali'    => 'datetime',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaModel::class, 'siswa_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(BukuModel::class, 'buku_id');
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(PengembalianModel::class, 'peminjaman_id');
    }

    public function deskripsiLog(string $aksi): ?string
    {
        if ($aksi !== 'tambah') {
            return null;
        }

        $nama  = $this->siswa?->nama_lengkap ?? 'Siswa';
        $judul = $this->buku?->judul ?? 'buku';

        return "{$nama} meminjam \"{$judul}\"";
    }
}
