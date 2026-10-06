<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DendaModel extends Model
{
    protected $table = 'dendas';
    protected $fillable = ['pengembalian_id', 'jumlah', 'keterangan', 'status_bayar'];

    public function pengembalian(): BelongsTo
    {
        return $this->belongsTo(PengembalianModel::class, 'pengembalian_id');
    }
}