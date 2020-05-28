<?php


namespace App\Controllers\Auth;


use App\Core\Request;
use App\Core\Route;
use App\Core\Session;
use App\Models\User;

class AuthController
{

    public function authenticate(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);
        /** @var User $user */
        $user = User::first(['email' => $request->email, 'password' => md5($request->password)]);
        if (empty($user)) {
            session()->set('error', 'Email atau password salah!');
            Route::back();
        }

        session()->set('__auth', $user);
        if ($user->isAdmin()) {
            Route::redirect('dashboard');
        }

        Route::redirect('/');
    }

    public function registration(Request $request)
    {
        $request->validate(['name' => 'required|name', 'email' => 'required|email', 'password' => 'required']);

        $sameEmail = User::find(['email' => $request->email]);
        if (count($sameEmail) > 0) {
            session()->set('error', 'Email sudah digunakan!');
            Route::back();
        }

        $user = (new User)->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => md5($request->password)
        ]);

        if (! $user) {
            session()->set('error', 'Pendaftaran gagal!');
            return Route::back();
        }

        session()->set('success', 'Pendaftaran berhasil! Silahkan login dengan email dan password baru anda');
        Route::redirect('auth/login');
    }

    public function login()
    {
        view('auth.login')->output();
    }

    public function register()
    {
        view('auth.register')->output();
    }
}