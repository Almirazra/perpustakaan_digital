<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PeminjamanModel extends Model
{
    protected $table = 'peminjamans';
    protected $fillable = [
        'siswa_id', 'buku_id', 'tanggal_peminjaman',
        'tanggal_kembali', 'jumlah', 'status',
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'date',
        'tanggal_kembali'    => 'date',
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
}