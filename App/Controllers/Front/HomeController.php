<?php

namespace App\Controllers\Front;


use \PDO;
use App\Models\Category;
use App\Models\Product;
use App\Controllers\Controller;

class HomeController extends Controller {

    public function index()
    {
        $products = Product::morphManyRaw('SELECT * FROM products ORDER BY created_at DESC LIMIT 15');
        view('home.index', compact('products'))->output();
    }

}
