<?php

namespace App\Controllers;


use App\Core\View;
use App\Models\Category;
use App\Models\Product;

class Controller {

    public function __construct()
    {
        View::shared([
            'categories' => Category::all(),
//            '_products' => Product::all()
        ]);
    }

}