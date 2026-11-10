<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\BukuModel as Buku;

class BukuApiController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->paginate(6);
        return BukuResource::collection($buku);
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return new BukuResource($buku);
    }
}
