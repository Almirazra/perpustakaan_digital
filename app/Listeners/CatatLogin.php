<?php

namespace App\Listeners;
use Illuminate\Auth\Events\Login;
use App\Models\ActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CatatLogin
{

    public function handle(Login $event): void
    {
        ActivityLog::log('login', 'User ' . $event->user->name . ' masuk ke sistem', $event->user->id);
    }
}
