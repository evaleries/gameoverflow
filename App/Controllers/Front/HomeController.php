<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::morphManyRaw('SELECT * FROM products ORDER BY created_at DESC LIMIT 15');
        view('home.index', compact('products'))->output();
    }
}
