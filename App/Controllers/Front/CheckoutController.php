<?php


namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\Request;
use App\Core\Route;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductCode;

class CheckoutController extends Controller
{

    private function hasItemsOnCartOrRedirect()
    {
        if (!session()->has('__cart', 'data') && count(session()->get('__cart')['data']) <= 0) {
            Route::back();
        }
    }

    public function index()
    {
        $this->hasItemsOnCartOrRedirect();
        $carts = session()->get('__cart');
        view('checkout.checkout', compact('carts'))->output();
    }

    public function process(Request $request)
    {
        session()->set('checkout_started', true);
        $this->hasItemsOnCartOrRedirect();
        $request->validate(['name' => 'required', 'bank_name' => 'required', 'bank_number' => 'required|numeric', 'description' => 'string']);

        if ($request->isError()) {
            return Route::back();
        }

        try {
            Order::PDO()->beginTransaction();

            $order = (new Order)->create([
                'user_id' => auth()->id,
                'description' => __e($request->get('description')),
                'status' => Order::PROCESSING
            ]);

            $carts = session()->get('__cart', ['data' => []]);

            if (empty($carts['data'])) {
                throw new \Exception("Cart kosong!");
            }

            if (! $order) {
                throw new \Exception("Order failed to create: ". $order);
            }

            $amount = 0;
            foreach ($carts['data'] as $productId => $cart) {
                $totalProductInDatabase = ProductCode::rawFirst("SELECT count(*) as total FROM product_codes WHERE product_id = :product_id AND status = :status AND user_id IS NULL", ['product_id' => $productId, 'status' => ProductCode::AVAILABLE]);

                if (isset($totalProductInDatabase->total)) $totalProductInDatabase = $totalProductInDatabase->total;
                else $totalProductInDatabase = 0;

                if ($totalProductInDatabase < $cart->quantity) {
                    throw new \Exception("Produk {$cart->title} melebihi stok yang tersedia. Silahkan menghubungi kami");
                }

                $amount += $cart->quantity * $cart->price;
                (new OrderItem)->create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $cart->quantity,
                    'price' => $cart->price
                ]);
            }

            (new Payment)->create([
                'order_id' => $order->id,
                'amount' => $amount,
                'bank_name' => __e($request->bank_name),
                'bank_number' => __e($request->bank_number),
                'status' => Payment::PENDING,
            ]);

            $due_date = new \DateTime('now');
            $due_date->add(\DateInterval::createFromDateString('1 week'));
            (new Invoice)->create([
                'order_id' => $order->id,
                'no' => generateInvoiceNo(),
                'title' => 'Invoice untuk Order #'. $order->id,
                'due_date' => $due_date->format('Y-m-d H:i:s')
            ]);

            Order::PDO()->commit();

        } catch (\Exception $e) {
            Order::PDO()->rollBack();
            session()->set('order_failed_reason', $e->getMessage());
            return Route::redirect('/checkout/failed');
        }

        session()->set('checkout_order_id', $order->id);

        return Route::redirect('/checkout/success');
    }

    public function success()
    {
        $this->isCheckoutHasStartedOrRedirect();
        
        view('checkout.status', ['status' => true, 'message' => 'Pesanan berhasil! Order #'. session()->flash('checkout_order_id') .' <br/> Invoice dapat dilihat pada dashboard'])->output();
        session()->unset('__cart');
        session()->unset('checkout_started');
    }

    public function failed()
    {
        $this->isCheckoutHasStartedOrRedirect();
        view('checkout.status', ['status' => false, 'message' => 'Pesanan gagal! ' . session()->flash('order_failed_reason')])->output();
        session()->unset('checkout_started');
    }

    private function isCheckoutHasStartedOrRedirect()
    {
        return session()->has('checkout_started') ? true : Route::redirect('/');
    }

}
