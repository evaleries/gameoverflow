<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\Request;
use App\Core\Route;
use App\Models\Category;
use App\Models\Developer;
use App\Models\Product;
use App\Models\ProductCode;
use Exception;
use PDO;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index')->output();
    }

    /**
     * @throws Exception
     */
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
            'game_codes' => 'required',
        ]);

        if ($request->isError()) {
            Route::back();
        }

        try {
            Product::PDO()->beginTransaction();

            $product = Product::create([
                'title' => __e($request->title),
                'developer_id' => $request->developer,
                'category_id' => $request->category,
                'price' => intval(str_replace(',', '', $request->price)),
                'slug' => slugify($request->title),
                'code' => $request->code,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'image' => $request->image,
                'released_at' => $request->released_at,
            ]);

            if (!$product) {
                throw new Exception('Produk gagal ditambahkan!');
            }

            $game_codes = explode("\r\n", $request->game_codes);
            foreach ($game_codes as $code) {
                $code = __e(trim($code));
                if (empty($code)) {
                    continue;
                }

                Product::create([
                    'product_id' => $product->id,
                    'user_id' => null,
                    'status' => ProductCode::AVAILABLE,
                    'activation_code' => $code,
                ]);
            }

            Product::PDO()->commit();
        } catch (Exception $e) {
            Product::PDO()->rollBack();
            session()->set('error', $e->getMessage());
            Route::back();
        }

        session()->set('success', 'Produk berhasil ditambahkan!');
        Route::redirect('/admin/products');
    }

    /**
     * @throws Exception
     */
    public function edit($slug, Request $request)
    {
        $product = Product::firstOrFail(compact('slug'));
        $developers = Developer::all(-1);
        $categories = Category::all(-1);

        return view('admin.products.edit', compact('product', 'developers', 'categories'))->output();
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
                'released_at' => $request->released_at,
            ]);

            if (!$product) {
                throw new Exception('Produk gagal diubah!');
            }

            Product::PDO()->commit();
        } catch (Exception $e) {
            Product::PDO()->rollBack();
            session()->set('error', $e->getMessage());
            Route::back();
        }

        session()->set('success', 'Produk berhasil dirubah!');
        Route::redirect('/admin/products');
    }

    /**
     * @throws Exception
     */
    public function stocks($productId, Request $request)
    {
        if (!$request->ajax()) {
            Route::error(400, 'Bad Request!');
        }

        $productCodes = ProductCode::raw('SELECT * FROM product_codes WHERE product_id = :product AND status = :status AND user_id IS NULL ORDER BY created_at DESC', ['product' => $productId, 'status' => ProductCode::AVAILABLE], PDO::FETCH_ASSOC);

        return json([
            'data' => $productCodes,
        ]);
    }

    /**
     * @throws Exception
     */
    public function updateStocks($productCodeId, Request $request)
    {
        if (!$request->ajax()) {
            Route::error(400, 'Bad Request');
        }
        $request->validate(['activation_code' => 'required']);

        if ($request->isError()) {
            return json(['message' => 'Activation code is required'], 422);
        }

        $productCode = ProductCode::firstOrFail(['id' => $productCodeId]);
        $productCode->update([
            'activation_code' => $request->activation_code,
        ]);

        return json(['message' => 'Success'], 200);
    }

    /**
     * @throws Exception
     */
    public function deleteStocks(Request $request)
    {
        if (!$request->ajax()) {
            Route::error(400, 'Bad Request');
        }
        $request->validate(['id' => 'required|int']);

        if ($request->isError()) {
            return json(['message' => 'Error!'], 422);
        }

        $productCode = ProductCode::firstOrFail(['id' => $request->id]);
        $productCode->delete();

        return json([], 204);
    }

    /**
     * @throws Exception
     */
    public function createStocks($product_id, Request $request)
    {
        if (!$request->ajax()) {
            Route::error(400, 'Bad Request');
        }
        $request->validate(['data' => 'required']);

        if ($request->isError()) {
            return json(['message' => 'Error!'], 422);
        }

        $activation_codes = explode("\n", $request->data);
        foreach ($activation_codes as $code) {
            ProductCode::create([
                'product_id' => $product_id,
                'activation_code' => trim($code),
                'user_id' => null,
                'status' => ProductCode::AVAILABLE,
            ]);
        }

        return json(['message' => 'OK'], 201);
    }

    /**
     * @throws Exception
     */
    public function api(Request $request)
    {
        if (!$request->ajax()) {
            Route::error(400, 'Bad Request!');
        }

        return json([
            'data' => Product::raw("SELECT p.id, p.slug, p.title, p.price, DATE_FORMAT(p.released_at, '%d %M %Y') as released_at, d.name as developer, c.name as category FROM products p JOIN developers d ON p.developer_id = d.id JOIN categories c ON p.category_id = c.id ORDER BY p.created_at desc", [], PDO::FETCH_ASSOC),
        ]);
    }
}
