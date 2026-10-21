<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'aksi',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function log(string $aksi, string $deskripsi, ?int $userId = null)
    {
        if(app()->runningInConsole()) {
            return;
        }
        self::create([
            'user_id' => $userId ?? Auth::id(),
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
        ]);

    }
}
