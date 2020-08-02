<?php

function isAuthenticated()
{
    return session()->has('__auth');
}

function requireLogin($to = null)
{
    return !isAuthenticated() ? \App\Core\Route::redirect('auth/login') : true;
}

function redirectIfLoggedIn()
{
    return isAuthenticated() ? \App\Core\Route::back() : null;
}

function requireAdmin()
{
    return requireLogin() && auth()->isAdmin() ? null : \App\Core\Route::error(403, 'You don\'t have a permission to access this feature');
}
