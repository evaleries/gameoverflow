<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Core\Request;
use App\Core\Route;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * @throws \Exception
     */
    public function authenticate(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);

        /** @var User $user */
        $user = User::first(['email' => $request->email, 'password' => md5($request->password)]);

        if (empty($user)) {
            session()->set('error', 'Email atau password salah!');
            return Route::back();
        }

        auth()->loginAs($user);

        if ($user->isAdmin()) {
            return redirect('admin');
        }

        return $this->redirectCustomer();
    }

    /**
     * @throws \Exception
     */
    public function registration(Request $request)
    {
        $request->validate(['name' => 'required|name', 'email' => 'required|email', 'password' => 'required']);

        $sameEmail = User::find(['%email%' => $request->email]);
        if (count($sameEmail) > 0) {
            session()->set('error', 'Email sudah digunakan!');
            Route::back();
        }

        $user = User::create([
            'name'     => __e($request->name),
            'email'    => strtolower($request->email),
            'password' => md5($request->password),
        ]);

        if (!$user) {
            session()->set('error', 'Pendaftaran gagal!');
            return Route::back();
        }

        session()->set('success', 'Pendaftaran berhasil!');
        auth()->loginAs($user);

        return $this->redirectCustomer();
    }

    public function logout(Request $request)
    {
        $request->validate(['logout_token' => 'required']);

        if (auth()->logoutToken() == $request->get('logout_token', 'INVALID')) {
            auth()->logout();
            session()->set('success', 'Logout berhasil!');
        }


        return redirect('/auth/login');
    }

    public function login()
    {
        view('auth.login')->output();
    }

    public function register()
    {
        view('auth.register')->output();
    }

    protected function redirectCustomer()
    {
        if (session()->has('__cart')) {
            return redirect('/cart');
        }

        return redirect('/customer');
    }
}
