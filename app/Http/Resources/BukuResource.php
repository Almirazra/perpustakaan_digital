<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'judul'        => $this->judul,
            'kategori'     => $this->kategori?->nama_kategori,
            'pengarang'    => $this->pengarang,
            'penerbit'     => $this->penerbit,
            'tahun_terbit' => $this->tahun_terbit,
            'stok'         => $this->stok,
            'lokasi_rak'   => $this->lokasi_rak,
            'sinopsis'     => $this->sinopsis,
            'cover_url'    => $this->cover ? asset('storage/' . $this->cover) : null,
        ];
    }
}
