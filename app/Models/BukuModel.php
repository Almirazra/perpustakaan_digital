<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\MencatatAktivitas;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BukuModel extends Model
{
    use MencatatAktivitas;
    protected $table = 'bukus';
    
    // Menambahkan 'cover' ke dalam fillable agar bisa disimpan ke database
    protected $fillable = [
        'kategori_id', 
        'judul', 
        'pengarang', 
        'penerbit', 
        'tahun_terbit', 
        'stok', 
        'lokasi_rak', 
        'cover',
        'sinopsis'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id');
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(PeminjamanModel::class, 'buku_id');
    }
    
    public function deskripsiLog(string $aksi): ?string
    {
        return match ($aksi) {
            'tambah' => "Buku \"{$this->judul}\" ditambahkan",
            'hapus'  => "Buku \"{$this->judul}\" dihapus",
            default  => null, // 'ubah' diabaikan karena stok berubah di setiap peminjaman
        };
    }
}