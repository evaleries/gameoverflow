<?php

use App\Controllers\Admin\CategoryController as AdminCategory;
use App\Controllers\Admin\DeveloperController as AdminDeveloper;
use App\Controllers\Admin\OrderController as AdminOrder;
use App\Controllers\Admin\ProductController as AdminProduct;
use App\Controllers\Auth\AuthController;
use App\Controllers\Front\CartController;
use App\Controllers\Front\CheckoutController;
use App\Core\Route;

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
Route::get('/admin/products', [AdminProduct::class, 'index'], 'requireAdmin');
Route::get('/admin/products/create', [AdminProduct::class, 'create'], 'requireAdmin');
Route::get('/admin/products/api', [AdminProduct::class, 'api'], 'requireAdmin');
Route::get('/admin/products/([a-z0-9_]+(?:-[a-z0-9]+)*)/edit', [AdminProduct::class, 'edit'], 'requireAdmin');
Route::post('/admin/products/([a-z0-9_]+(?:-[a-z0-9]+)*)/update', [AdminProduct::class, 'update'], 'requireAdmin');

Route::get('/admin/products/(\d+)/stocks', [AdminProduct::class, 'stocks'], 'requireAdmin');
Route::post('/admin/products/stocks/(\d+)/update', [AdminProduct::class, 'updateStocks'], 'requireAdmin');
Route::post('/admin/products/stocks/delete', [AdminProduct::class, 'deleteStocks'], 'requireAdmin');
Route::post('/admin/products/(\d+)/stocks/create', [AdminProduct::class, 'createStocks', 'requireAdmin']);
Route::post('/admin/products/store', [AdminProduct::class, 'store'], 'requireAdmin');

Route::get('/admin/orders', [AdminOrder::class, 'index'], 'requireAdmin');
Route::get('/admin/orders/api', [AdminOrder::class, 'api'], 'requireAdmin');
Route::get('/admin/orders/detail/(\d+)', [AdminOrder::class, 'show'], 'requireAdmin');
Route::post('/admin/orders/(\d+)/confirm', [AdminOrder::class, 'confirm'], 'requireAdmin');
Route::post('/admin/orders/(\d+)/cancel', [AdminOrder::class, 'cancel'], 'requireAdmin');
Route::get('/admin/orders/recap', [AdminOrder::class, 'recap'], 'requireAdmin');
Route::post('/admin/orders/recap/data', [AdminOrder::class, 'recapData'], 'requireAdmin');

Route::get('/admin/categories', [AdminCategory::class, 'index'], 'requireAdmin');
Route::get('/admin/categories/api', [AdminCategory::class, 'api'], 'requireAdmin');
Route::post('/admin/categories/store', [AdminCategory::class, 'store'], 'requireAdmin');
Route::post('/admin/categories/update', [AdminCategory::class, 'update'], 'requireAdmin');
Route::post('/admin/categories/delete', [AdminCategory::class, 'delete'], 'requireAdmin');

Route::get('/admin/developers', [AdminDeveloper::class, 'index'], 'requireAdmin');
Route::get('/admin/developers/api', [AdminDeveloper::class, 'api'], 'requireAdmin');
Route::post('/admin/developers/store', [AdminDeveloper::class, 'store'], 'requireAdmin');
Route::post('/admin/developers/update', [AdminDeveloper::class, 'update'], 'requireAdmin');
Route::post('/admin/developers/delete', [AdminDeveloper::class, 'delete'], 'requireAdmin');

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
