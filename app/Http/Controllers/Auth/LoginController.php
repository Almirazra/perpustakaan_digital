<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Memodifikasi parameter pencarian kredensial login.
     * Menangani input otomatis apakah user memasukkan Email utuh atau sekadar NIS.
     */
    protected function credentials(Request $request)
    {
        // Ambil inputan dari form login (menggunakan name="email" sesuai bawaan Laravel)
        $login = $request->get('email'); 

        // Cek apakah inputan berbentuk format email yang valid
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
            $value = $login;
        } else {
            // Jika bukan email (berarti NIS), otomatis tambahkan domain siswa di belakangnya
            $field = 'email';
            $value = $login . '@siswa.perpus.test';
        }

        return [
            $field => $value,
            'password' => $request->get('password'),
        ];
    }
}