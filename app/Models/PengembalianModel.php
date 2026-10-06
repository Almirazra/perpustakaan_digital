<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengembalian extends Model
{
    protected $table = 'pengembalians';
    protected $fillable = [
        'peminjaman_id', 'tanggal_pengembalian',
        'keterlambatan', 'denda', 'status',
    ];
    protected $casts = ['tanggal_pengembalian' => 'date'];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    // dinamai dendaDetail agar tidak bentrok dengan kolom `denda`
    public function dendaDetail(): HasOne
    {
        return $this->hasOne(Denda::class, 'pengembalian_id');
    }
}