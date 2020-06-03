<?php

use App\Core\Route;
use App\Controllers\Front\CartController;
use App\Controllers\Front\CheckoutController;
use App\Controllers\Auth\AuthController;

Route::get('/', '\App\Controllers\Front\HomeController@index');
Route::get('/categories', '\App\Controllers\Front\HomeController@categories');
Route::get('/categories/(\w+)', [App\Controllers\Front\HomeController::class, 'category']);

Route::get('/cart', [CartController::class, 'index']);
Route::get('/cart/clear', [CartController::class, 'clear']);
Route::post('/cart', [CartController::class, 'add']);
Route::post('/cart/delete', [CartController::class, 'delete']);
Route::post('/cart/update', [CartController::class, 'update']);

Route::get('/checkout', [CheckoutController::class, 'index'], 'requireLogin');
Route::post('/checkout/process', [CheckoutController::class, 'process'], 'requireLogin');
Route::get('/checkout/success', [CheckoutController::class, 'success'], 'requireLogin');
Route::get('/checkout/failed', [CheckoutController::class, 'failed'], 'requireLogin');

Route::get('/admin', [App\Controllers\Admin\DashboardController::class, 'index'], 'requireAdmin');
Route::get('/admin/products', [App\Controllers\Admin\ProductController::class, 'index'], 'requireAdmin');
Route::get('/admin/products/create', [App\Controllers\Admin\ProductController::class, 'create'], 'requireAdmin');
Route::get('/admin/products/api', [App\Controllers\Admin\ProductController::class, 'api'], 'requireAdmin');
Route::get('/admin/products/([a-z0-9_]+(?:-[a-z0-9]+)*)/edit', [App\Controllers\Admin\ProductController::class, 'edit'], 'requireAdmin');
Route::post('/admin/products/([a-z0-9_]+(?:-[a-z0-9]+)*)/update', [App\Controllers\Admin\ProductController::class, 'update'], 'requireAdmin');
Route::get('/admin/products/(\d+)/stocks', [App\Controllers\Admin\ProductController::class, 'stocks'], 'requireAdmin');
Route::post('/admin/products/stocks/(\d+)/update', [App\Controllers\Admin\ProductController::class, 'updateStocks'], 'requireAdmin');
Route::post('/admin/products/stocks/delete', [App\Controllers\Admin\ProductController::class, 'deleteStocks'], 'requireAdmin');
Route::post('/admin/products/(\d+)/stocks/create', [App\Controllers\Admin\ProductController::class, 'createStocks', 'requireAdmin']);
Route::post('/admin/products/store', [App\Controllers\Admin\ProductController::class, 'store'], 'requireAdmin');

Route::get('/admin/orders', [App\Controllers\Admin\OrderController::class, 'index'], 'requireAdmin');
Route::get('/admin/orders/api', [App\Controllers\Admin\OrderController::class, 'api'], 'requireAdmin');
Route::get('/admin/orders/detail/(\d+)', [App\Controllers\Admin\OrderController::class, 'show'], 'requireAdmin');
Route::post('/admin/orders/(\d+)/confirm', [App\Controllers\Admin\OrderController::class, 'confirm'], 'requireAdmin');
Route::post('/admin/orders/(\d+)/cancel', [App\Controllers\Admin\OrderController::class, 'cancel'], 'requireAdmin');
Route::get('/admin/orders/recap', [App\Controllers\Admin\OrderController::class, 'recap'], 'requireAdmin');
Route::post('/admin/orders/recap/data', [App\Controllers\Admin\OrderController::class, 'recapData'], 'requireAdmin');

Route::get('/customer', [App\Controllers\Customer\DashboardController::class, 'index'], 'requireLogin');
Route::get('/customer/invoice', [App\Controllers\Customer\DashboardController::class, 'invoice'], 'requireLogin');
Route::post('/customer/redeem', [App\Controllers\Customer\DashboardController::class, 'redeemProduct'], 'requireLogin');

Route::get('/auth/login', [AuthController::class, 'login'], 'redirectIfLoggedIn');
Route::get('/auth/register', [AuthController::class, 'register'], 'redirectIfLoggedIn');
Route::post('/auth/authenticate', [AuthController::class, 'authenticate'], 'redirectIfLoggedIn');
Route::post('/auth/registration', [AuthController::class, 'registration'], 'redirectIfLoggedIn');
Route::post('/auth/logout', [AuthController::class, 'logout'], 'requireLogin');

Route::get('/products', [App\Controllers\Front\ProductController::class, 'index']);
Route::get('/products/search', [App\Controllers\Front\ProductController::class, 'search']);
Route::get('/products/([a-z0-9_]+(?:-[a-z0-9]+)*)', [App\Controllers\Front\ProductController::class, 'show']);

Route::get('/admin/product/codes/generate', function () {
    echo '<pre>';
    for ($i=0; $i < 10; $i++) {
        var_dump((new \App\Models\ProductCode)->create([
            'product_id' => rand(1, 10),
            'user_id' => null,
            'status' => 0,
            'activation_code' => generateActivationCode()
        ]));
    }
    echo '</pre>';
}, 'requireAdmin');
