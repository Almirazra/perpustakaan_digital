<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LoginController extends Controller implements HasMiddleware
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['logout']),
        ];
    }
}
