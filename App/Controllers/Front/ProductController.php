<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\Request;
use App\Models\Product;
use App\Models\ProductCode;
use PDO;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $options = [];
        if ($request->category) {
            $query = 'SELECT p.* FROM products p JOIN categories c ON p.category_id = c.id WHERE c.slug = :slug';
            $options['data'] = Product::morphManyRaw($query, ['slug' => $request->category], PDO::FETCH_ASSOC);
            $options['total_query'] = 'SELECT count(*) FROM products p JOIN categories c ON p.category_id = c.id WHERE c.slug = :slug';
            $options['param_query'] = ['slug' => $request->category];
        }

        $products = Product::paginate($request->get('page', 1), 9, $options);

        view('products.index', compact('products'))->output();
    }

    public function search(Request $request)
    {
        $request->validate(['q' => 'string']);

        $searchQuery = ['q' => '%'.$request->q.'%'];
        $options['data'] = Product::morphManyRaw('SELECT * FROM products WHERE title LIKE :q OR code LIKE :q OR description LIKE :q', $searchQuery, PDO::FETCH_ASSOC);
        $options['total_query'] = 'SELECT count(*) FROM products WHERE title LIKE :q OR code LIKE :q OR description LIKE :q';
        $options['param_query'] = $searchQuery;

        $products = Product::paginate($request->get('page', 1), 9, $options);

        view('products.search', compact('products'))->output();
    }

    public function show($slug, Request $request)
    {
        $query = 'SELECT p.*, d.name as developer_name, d.website as developer_website, c.slug as category_slug, c.name as category_name 
        FROM products p 
        LEFT JOIN developers d ON p.developer_id = d.id 
        JOIN categories c ON p.category_id = c.id 
        WHERE p.slug = :slug
        ORDER BY p.created_at DESC';
        $product = Product::morphRaw($query, compact('slug'), PDO::FETCH_ASSOC);

        ProductCode::raw('SELECT * FROM product_codes WHERE product_id = :product AND user_id IS NULL AND status = 0', ['product' => $product->id]);
        $stock = ProductCode::DB()->count();

        view('products.show', compact('product', 'stock'))->output();
    }
}
