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

Route::get('/checkout', [CheckoutController::class, 'index'], 'auth');
Route::post('/checkout/process', [CheckoutController::class, 'process'], 'auth');
Route::get('/checkout/success', [CheckoutController::class, 'success'], 'auth');
Route::get('/checkout/failed', [CheckoutController::class, 'failed'], 'auth');

Route::get('/admin', [App\Controllers\Admin\DashboardController::class, 'index'], 'auth|role:admin');
Route::get('/admin/products', [AdminProduct::class, 'index'], 'auth|role:admin');
Route::get('/admin/products/create', [AdminProduct::class, 'create'], 'auth|role:admin');
Route::get('/admin/products/api', [AdminProduct::class, 'api'], 'auth|role:admin');
Route::get('/admin/products/([a-z0-9_]+(?:-[a-z0-9]+)*)/edit', [AdminProduct::class, 'edit'], 'auth|role:admin');
Route::post('/admin/products/([a-z0-9_]+(?:-[a-z0-9]+)*)/update', [AdminProduct::class, 'update'], 'auth|role:admin');

Route::get('/admin/products/(\d+)/stocks', [AdminProduct::class, 'stocks'], 'auth|role:admin');
Route::post('/admin/products/stocks/(\d+)/update', [AdminProduct::class, 'updateStocks'], 'auth|role:admin');
Route::post('/admin/products/stocks/delete', [AdminProduct::class, 'deleteStocks'], 'auth|role:admin');
Route::post('/admin/products/(\d+)/stocks/create', [AdminProduct::class, 'createStocks', 'auth|role:admin']);
Route::post('/admin/products/store', [AdminProduct::class, 'store'], 'auth|role:admin');

Route::get('/admin/orders', [AdminOrder::class, 'index'], 'auth|role:admin');
Route::get('/admin/orders/api', [AdminOrder::class, 'api'], 'auth|role:admin');
Route::get('/admin/orders/detail/(\d+)', [AdminOrder::class, 'show'], 'auth|role:admin');
Route::post('/admin/orders/(\d+)/confirm', [AdminOrder::class, 'confirm'], 'auth|role:admin');
Route::post('/admin/orders/(\d+)/cancel', [AdminOrder::class, 'cancel'], 'auth|role:admin');
Route::get('/admin/orders/recap', [AdminOrder::class, 'recap'], 'auth|role:admin');
Route::post('/admin/orders/recap/data', [AdminOrder::class, 'recapData'], 'auth|role:admin');

Route::get('/admin/categories', [AdminCategory::class, 'index'], 'auth|role:admin');
Route::get('/admin/categories/api', [AdminCategory::class, 'api'], 'auth|role:admin');
Route::post('/admin/categories/store', [AdminCategory::class, 'store'], 'auth|role:admin');
Route::post('/admin/categories/update', [AdminCategory::class, 'update'], 'auth|role:admin');
Route::post('/admin/categories/delete', [AdminCategory::class, 'delete'], 'auth|role:admin');

Route::get('/admin/developers', [AdminDeveloper::class, 'index'], 'auth|role:admin');
Route::get('/admin/developers/api', [AdminDeveloper::class, 'api'], 'auth|role:admin');
Route::post('/admin/developers/store', [AdminDeveloper::class, 'store'], 'auth|role:admin');
Route::post('/admin/developers/update', [AdminDeveloper::class, 'update'], 'auth|role:admin');
Route::post('/admin/developers/delete', [AdminDeveloper::class, 'delete'], 'auth|role:admin');

Route::get('/customer', [App\Controllers\Customer\DashboardController::class, 'index'], 'auth');
Route::get('/customer/invoice', [App\Controllers\Customer\DashboardController::class, 'invoice'], 'auth');
Route::post('/customer/redeem', [App\Controllers\Customer\DashboardController::class, 'redeemProduct'], 'auth');

Route::get('/auth/login', [AuthController::class, 'login'], 'guest');
Route::get('/auth/register', [AuthController::class, 'register'], 'guest');
Route::post('/auth/authenticate', [AuthController::class, 'authenticate'], 'guest');
Route::post('/auth/registration', [AuthController::class, 'registration'], 'guest');
Route::post('/auth/logout', [AuthController::class, 'logout'], 'auth');

Route::get('/products', [App\Controllers\Front\ProductController::class, 'index']);
Route::get('/products/search', [App\Controllers\Front\ProductController::class, 'search']);
Route::get('/products/([a-z0-9_]+(?:-[a-z0-9]+)*)', [App\Controllers\Front\ProductController::class, 'show']);
