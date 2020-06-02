<?php

namespace App\Controllers\Admin;


use App\Core\Route;
use App\Models\User;
use App\Core\Request;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Models\ProductCode;
use App\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index')->output();
    }
    
    public function show($order_id, Request $request)
    {
        $order = Order::firstOrFail(['id' => $order_id]);
        $orderItems = OrderItem::morphManyRaw('SELECT oi.*, p.title FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = :order_id', ['order_id' => $order->id]);
        $invoice = Invoice::firstOrFail(['order_id' => $order->id]);
        $payment = Payment::firstOrFail(['order_id' => $order->id]);
        $user = User::firstOrFail(['id' => $order->user_id]);

        return view('admin.orders.show', compact('order', 'orderItems', 'invoice', 'payment', 'user'))->output();
    }

    public function confirm($order_id, Request $request)
    {
        if (! $request->ajax()) {
            Route::error(400, 'Bad Request');
        }

        $request->validate(['id' => 'required|int']);

        if ($request->isError()) {
            return json(['message' => 'Invalid request'], 422);
        }

        try {
            Order::PDO()->beginTransaction();

            $order = Order::firstOrFail(['id' => $request->id]);

            if ($order->status == Order::COMPLETED) {
                throw new \Exception("Tidak dapat mengkonfirmasi pesanan yang telah selesai.");
            } elseif ($order->status == Order::CANCELLED) {
                throw new \Exception("Tidak dapat mengkonfirmasi pesanan yang telah dibatalkan.");
            }

            $orderItems = OrderItem::find(['order_id' => $order->id]);
    
            foreach ($orderItems as $item) {
                $productCode = ProductCode::morphRaw('SELECT * FROM product_codes WHERE user_id IS NULL AND status = :status AND product_id = :product_id', ['status' => ProductCode::AVAILABLE, 'product_id' => $item->product_id]);
                
                if (empty($productCode)) {
                    throw new \Exception("Stok produk dengan id {$item->product_id} tidak mencukupi. Silahkan menambah stock");
                }

                $productCode->update([
                    'user_id' => $order->user_id
                ]);
            }

            $payment = Payment::firstOrFail(['order_id' => $order->id]);
            $payment->update([
                'status' => Payment::CONFIRMED
            ]);

            $order->update([
                'status' => Order::COMPLETED
            ]);

            Order::PDO()->commit();

        } catch (\Exception $e) {
            Order::PDO()->rollBack();
            return json(['message' => $e->getMessage(), 'status' => false], 200);
        }
        
        return json(['status' => true, 'message' => 'OK'], 200);
    }

    public function cancel($order_id, Request $request)
    {
        if (! $request->ajax()) {
            Route::error(400, 'Bad Request');
        }

        $request->validate(['id' => 'required|int']);

        if ($request->isError()) {
            return json(['message' => 'Invalid request'], 422);
        }

        try {
            Order::PDO()->beginTransaction();

            $order = Order::firstOrFail(['id' => $request->id]);

            if ($order->status == Order::COMPLETED) {
                throw new \Exception("Tidak dapat membatalkan pesanan yang telah selesai.");
            } elseif ($order->status == Order::CANCELLED) {
                throw new \Exception("Tidak dapat membatalkan pesanan yang telah dibatalkan.");
            }

            $order->update([
                'status' => Order::CANCELLED
            ]);

            Order::PDO()->commit();
        } catch (\Exception $e) {
            Order::PDO()->rollBack();
            return json(['message' => $e->getMessage()], 200);
        }

        return json(['status' => true, 'message' => 'OK'], 200);
    }

    public function api(Request $request)
    {
        if (! $request->ajax()) {
            Route::error(400, 'Bad Request');
        }

        return json([
            'data' => Order::raw("SELECT o.id, i.no as invoice_no, o.status as order_status, p.status as payment_status, DATE_FORMAT(o.created_at, '%d/%m/%Y %H:%i %p') as created_at, DATE_FORMAT(i.due_date, '%d/%m/%Y') as due_date FROM orders o JOIN invoices i ON i.order_id = o.id JOIN payments p ON p.order_id = o.id ORDER BY o.created_at DESC", null, \PDO::FETCH_ASSOC)
        ]);
    }
}