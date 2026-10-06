<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotifikasiModel extends Model
{
    protected $table = 'notifikasis';
    protected $fillable = ['siswa_id', 'judul', 'pesan', 'status'];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaModel::class, 'siswa_id');
    }

    // kirim()
    public static function kirim(int $siswaId, string $judul, string $pesan): self
    {
        return self::create([
            'siswa_id' => $siswaId,
            'judul'    => $judul,
            'pesan'    => $pesan,
            'status'   => 'belum_dibaca',
        ]);
    }

    // tandaiDibaca()
    public function tandaiDibaca(): bool
    {
        return $this->update(['status' => 'dibaca']);
    }
}