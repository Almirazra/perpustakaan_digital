<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswas';
    protected $fillable = ['nis', 'nama_lengkap', 'kelas', 'jurusan', 'telp'];

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'siswa_id');
    }

    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'siswa_id');
    }
}