<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\MencatatAktivitas;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiswaModel extends Model
{
    use MencatatAktivitas;
    protected $table = 'siswas';
    protected $fillable = ['nis', 'nama_lengkap', 'kelas', 'jurusan', 'telp', 'password'];

    public function peminjamans(): HasMany
    {
        return $this->hasMany(PeminjamanModel::class, 'siswa_id');
    }

    public function notifikasis(): HasMany
    {
        return $this->hasMany(NotifikasiModel::class, 'siswa_id');
    }
    public function deskripsiLog(string $aksi): ?string
{
    return match ($aksi) {
        'tambah' => "Kartu anggota dibuat untuk {$this->nama_lengkap} ({$this->nis})",
        'ubah'   => "Data siswa {$this->nama_lengkap} diperbarui",
        'hapus'  => "Siswa {$this->nama_lengkap} dihapus",
    };
}
}
