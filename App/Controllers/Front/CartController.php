<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\Request;
use App\Core\Route;
use App\Core\Session;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $carts = session()->get('__cart', []);
        view('cart', compact('carts'))->output();
    }

    public function add(Request $request)
    {
        $request->validate(['id' => 'numeric|int', 'slug' => 'string', 'quantity' => 'int']);
        $carts = session()->get('__cart', []);

        if (isset($carts['data'][$request->id]) && isset($carts['data'][$request->id]->quantity)) {
            $carts['data'][$request->id]->quantity = $request->quantity + $carts['data'][$request->id]->quantity;
            $carts['data'][$request->id]->totalPrice = $carts['data'][$request->id]->quantity * $carts['data'][$request->id]->price;
            $carts['data'][$request->id]->formattedTotalPrice = Product::humanizePrice($carts['data'][$request->id]->totalPrice);
        } else {
            $product = Product::firstOrFail(['id' => $request->id, 'slug' => $request->slug]);
            $totalPrice = $product->price * (intval($request->quantity));

            $carts['data'][$product->id] = (object) [
                'quantity'            => intval($request->quantity),
                'title'               => $product->title,
                'image'               => $product->getAssetImage(),
                'url'                 => route('products/'.$product->slug),
                'price'               => $product->price,
                'totalPrice'          => $totalPrice,
                'formattedPrice'      => Product::humanizePrice($product->price),
                'formattedTotalPrice' => Product::humanizePrice($totalPrice),
            ];
        }

        $this->updateCart($carts);

        Route::redirect('cart');
    }

    public function update(Request $request)
    {
        $request->validate(['data' => 'array']);
        if (!$request->ajax()) {
            throw new \Exception('Unauthorized', 401);
        }

        $carts = session()->get('__cart', []);

        if (session()->has('__cart', 'data')) {
            if (is_array($request->data)) {
                foreach ($request->data as $itemId => $quantity) {
                    if (!isset($carts['data'][$itemId]->quantity)) {
                        continue;
                    }

                    $item = $carts['data'][$itemId];
                    $item->quantity = intval($quantity);
                    $item->totalPrice = $item->quantity * $item->price;
                    $item->formattedPrice = Product::humanizePrice($item->price);
                    $item->formattedTotalPrice = Product::humanizePrice($carts['data'][$itemId]->totalPrice);
                    $carts['data'][$itemId] = $item;
                }
            } elseif (isset($carts['data'][$request->id])) {
                $item = $carts['data'][$request->id];

                if ($request->quantity) {
                    $item->quantity = intval($request->quantity);
                }

                $carts['data'][$request->id] = $item;
            }
            $this->updateCart($carts);

            return json(['code' => 200, 'message' => 'Item has been updated']);
        }

        return json(['code' => 422], 422);
    }

    public function delete(Request $request)
    {
        $request->validate(['id' => 'int']);
        if (!$request->ajax()) {
            throw new \Exception('Unauthorized', 401);
        }

        if (isset(session()->get('__cart', [])['data'][$request->id])) {
            $carts = session()->get('__cart', []);
            unset($carts['data'][$request->id]);

            $this->updateCart($carts);

            return json(['code' => 204, 'message' => 'Item has successfully deleted from cart'], 204);
        }

        return json(['code' => 404], 404);
    }

    public function clear()
    {
        session()->unset('__cart');
        Route::redirect('/');
    }

    private function updateCart($carts)
    {
        $carts['totalPrice'] = 0;
        $carts['totalProducts'] = 0;
        foreach ($carts['data'] as $productId => $cart) {
            $carts['totalPrice'] += $cart->totalPrice;
            $carts['totalProducts'] += $cart->quantity;
        }
        $carts['formattedTotalPrice'] = Product::humanizePrice($carts['totalPrice']);

        session()->set('__cart', $carts);
    }
}
