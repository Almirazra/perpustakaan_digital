<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BukuModel extends Model
{
    protected $table = 'bukus';
    protected $fillable = [
        'kategori_id', 'judul', 'pengarang', 'penerbit',
        'tahun_terbit', 'stok', 'lokasi_rak',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id');
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(PeminjamanModel::class, 'buku_id');
    }
}