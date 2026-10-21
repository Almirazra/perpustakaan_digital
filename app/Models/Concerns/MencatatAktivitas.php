<?php

namespace App\Models\Concerns;
use Illuminate\Database\Eloquent\Model;
use Closure;
use App\Models\ActivityLog;

/**
 * @method static void created(Closure|string $callback)
 * @method static void updated(Closure|string $callback)
 * @method static void deleted(Closure|string $callback)
 */
trait MencatatAktivitas
{
    protected static function bootMencatatAktivitas(): void
    {
        static::created(fn ($m) => self::log('tambah', $m));
        static::updated(fn ($m) => self::log('ubah', $m));
        static::deleted(fn ($m) => self::log('hapus', $m));
    }

    private static function log(string $aksi, Model $model): void
    {
        $teks = $model->deskripsiLog($aksi);

        if ($teks !== null) {
            ActivityLog::log($aksi, $teks);
        }
    }
}
