<?php

use App\Core\Route;

Route::get('/', '\App\Controllers\Front\HomeController@index');
Route::get('/categories', '\App\Controllers\Front\HomeController@categories');
Route::get('/categories/(\w+)', [App\Controllers\Front\HomeController::class, 'category']);

Route::get('/cart', [App\Controllers\Front\CartController::class, 'index']);
Route::get('/cart/clear', [App\Controllers\Front\CartController::class, 'clear']);
Route::post('/cart', [App\Controllers\Front\CartController::class, 'add']);
Route::post('/cart/delete', [App\Controllers\Front\CartController::class, 'delete']);
Route::post('/cart/update', [App\Controllers\Front\CartController::class, 'update']);

Route::get('/checkout', [App\Controllers\Front\CheckoutController::class, 'index'], 'requireLogin');
Route::post('/checkout/process', [App\Controllers\Front\CheckoutController::class, 'process'], 'requireLogin');
Route::get('/checkout/success', [App\Controllers\Front\CheckoutController::class, 'success'], 'requireLogin');
Route::get('/checkout/failed', [App\Controllers\Front\CheckoutController::class, 'failed'], 'requireLogin');

Route::get('/admin', [App\Controllers\Admin\DashboardController::class, 'index'], 'requireAdmin');
Route::get('/admin/products', [App\Controllers\Admin\DashboardController::class, 'products'], 'requireAdmin');
Route::get('/admin/products/create', [App\Controllers\Admin\ProductController::class, 'create'], 'requireAdmin');

Route::get('/customer', [App\Controllers\Customer\DashboardController::class, 'index'], 'requireLogin');
Route::get('/customer/invoice', [App\Controllers\Customer\DashboardController::class, 'invoice'], 'requireLogin');
Route::post('/customer/redeem', [App\Controllers\Customer\DashboardController::class, 'redeemProduct'], 'requireLogin');

Route::get('/auth/login', [App\Controllers\Auth\AuthController::class, 'login'], 'redirectIfLoggedIn');
Route::get('/auth/register', [App\Controllers\Auth\AuthController::class, 'register'], 'redirectIfLoggedIn');
Route::post('/auth/authenticate', [App\Controllers\Auth\AuthController::class, 'authenticate'], 'redirectIfLoggedIn');
Route::post('/auth/registration', [App\Controllers\Auth\AuthController::class, 'registration'], 'redirectIfLoggedIn');
Route::post('/auth/logout', [App\Controllers\Auth\AuthController::class, 'logout'], 'requireLogin');

Route::get('/products', [App\Controllers\Front\ProductController::class, 'index']);
Route::get('/products/search', [App\Controllers\Front\ProductController::class, 'search']);
Route::get('/products/([a-z0-9_]+(?:-[a-z0-9]+)*)', [App\Controllers\Front\ProductController::class, 'show']);
