<?php

namespace App\Controllers\Admin;


use App\Core\Route;
use App\Core\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Developer;
use App\Models\ProductCode;
use App\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index')->output();
    }

    public function create()
    {
        $developers = Developer::all(-1);
        return view('admin.products.create', compact('developers'))->output();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required',
            'price' => 'required',
            'developer' => 'required|int',
            'category' => 'required|int',
            'short_description' => 'string',
            'description' => 'string',
            'image' => 'required',
            'released_at' => 'required',
            'game_codes' => 'required'
        ]);

        if ($request->isError()) {
            Route::back();
        }

        try {
            Product::PDO()->beginTransaction();

            $product = (new Product)->create([
                'title' => __e($request->title),
                'developer_id' => $request->developer,
                'category_id' => $request->category,
                'price' => intval(str_replace(',', '', $request->price)),
                'slug' => slugify($request->title),
                'code' => $request->code,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'image' => $request->image,
                'released_at' => $request->released_at
            ]);

            if (! $product) {
                throw new Exception('Produk gagal ditambahkan!');
            }

            $game_codes = explode("\r\n", $request->game_codes);
            foreach ($game_codes as $code) {
                $code = __e(trim($code));
                if (empty($code)) continue;

                (new ProductCode)->create([
                    'product_id' => $product->id,
                    'user_id' => null,
                    'status' => ProductCode::AVAILABLE,
                    'activation_code' => $code
                ]);
            }

            Product::PDO()->commit();

        } catch (\Exception $e) {
            Product::PDO()->rollBack();
            session()->set('error', $e->getMessage());
            Route::back();
        }

        session()->set('success', 'Produk berhasil ditambahkan!');
        Route::redirect('/admin/products');
    }

    public function edit($slug, Request $request)
    {
        $product = Product::firstOrFail(compact('slug'));
        $developers = Developer::all(-1);
        $categories = Category::all(-1);

        return view('admin.products.edit', compact('product', 'productCodes', 'developers', 'categories'))->output();
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|int',
            'title' => 'required',
            'code' => 'required',
            'price' => 'required',
            'developer' => 'required|int',
            'category' => 'required|int',
            'short_description' => 'string',
            'description' => 'string',
            'image' => 'required',
            'released_at' => 'required',
        ]);

        if ($request->isError()) {
            Route::back();
        }

        try {
            Product::PDO()->beginTransaction();

            $product = Product::firstOrFail(['id' => $request->product_id]);
            $product->update([
                'title' => __e($request->title),
                'developer_id' => $request->developer,
                'category_id' => $request->category,
                'price' => intval(str_replace(',', '', $request->price)),
                'slug' => slugify($request->title),
                'code' => $request->code,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'image' => $request->image,
                'released_at' => $request->released_at
            ]);

            if (! $product) {
                throw new Exception('Produk gagal diubah!');
            }

            Product::PDO()->commit();

        } catch (\Exception $e) {
            Product::PDO()->rollBack();
            session()->set('error', $e->getMessage());
            Route::back();
        }

        session()->set('success', 'Produk berhasil dirubah!');
        Route::redirect('/admin/products');
    }

    public function stocks($productId, Request $request)
    {
        if (! $request->ajax()) {
            Route::error(400, 'Bad Request!');
        }

        $productCodes = ProductCode::raw('SELECT * FROM product_codes WHERE product_id = :product AND status = :status AND user_id IS NULL', ['product' => $productId, 'status' => ProductCode::AVAILABLE], \PDO::FETCH_ASSOC);

        return json([
            'data' => $productCodes
        ]);
    }

    public function api(Request $request)
    {
        if (! $request->ajax()) {
            Route::error(400, 'Bad Request!');
        }

        return json([
            'data' => Product::raw("SELECT p.id, p.slug, p.title, p.price, DATE_FORMAT(p.released_at, '%d %M %Y') as released_at, d.name as developer, c.name as category FROM products p JOIN developers d ON p.developer_id = d.id JOIN categories c ON p.category_id = c.id ORDER BY p.created_at desc", null, \PDO::FETCH_ASSOC)
        ]);
    }
}
