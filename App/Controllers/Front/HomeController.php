<?php

namespace App\Controllers\Front;


use \PDO;
use App\Models\Category;
use App\Models\Product;
use App\Controllers\Controller;

class HomeController extends Controller {

    public function index()
    {
        $products = Product::all(10);
        view('home.index', compact('products'))->output();
    }

    public function post() {

    }

    public function categories() {
        $categories = Category::all();
        foreach ($categories as $cat) {
            print_r($cat);
        }
    }

    public function category($slug) {
        $cat = Category::firstOrFail(['%slug%' => $slug]);
        echo "<h1>{$cat->name}</h1>";
        echo "<p>{$cat->description}</p>";
        echo "<img src='{$cat->getImage()}'>";
    }

}