<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriModel extends Model
{
    protected $table = 'kategoris';
    protected $fillable = ['nama_kategori', 'keterangan'];

    public function bukus(): HasMany
    {
        return $this->hasMany(BukuModel::class, 'kategori_id');
    }
}