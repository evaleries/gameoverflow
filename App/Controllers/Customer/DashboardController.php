<?php

namespace App\Controllers\Customer;


use App\Core\Route;
use App\Core\Request;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\ProductCode;
use App\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() 
    {
        $orders = Order::morphManyRaw("SELECT o.*, i.no, i.due_date, i.title, p.status as payment_status FROM orders o JOIN invoices i ON o.id = i.order_id JOIN payments p ON p.order_id = o.id WHERE o.user_id = :user ORDER BY o.created_at DESC", ['user' => auth()->id]);
        $myGames = ProductCode::raw("SELECT pc.*, p.title, o.id as order_id, o.created_at as bought_date FROM `product_codes` pc JOIN orders o ON pc.user_id = o.user_id JOIN products p ON pc.product_id = p.id WHERE pc.user_id = :user AND o.status = :status ORDER BY o.created_at DESC", ['user' => auth()->id, 'status' => Order::COMPLETED]);
        $totalGameOwned = Product::rawFirst("SELECT count(*) as total FROM product_codes WHERE user_id = :user", ['user' => auth()->id])->total;
        $totalProductInStore = Product::rawFirst("SELECT count(*) as total FROM products")->total;   

        return view('customer.dashboard', compact('totalProductInStore', 'totalGameOwned', 'orders', 'myGames'))->output();
    }

    public function invoice(Request $request)
    {
        $request->validate(['no' => 'required']);

        if (! $request->no) {
            Route::back('/customer');
        }

        $invoice = Invoice::morphRaw("SELECT i.*, p.bank_name, p.bank_number, o.created_at as order_date, o.id as order_id FROM invoices i JOIN orders o ON i.order_id = o.id JOIN payments p ON p.order_id = o.id WHERE o.user_id = :user AND i.no = :invoice", ['user' => auth()->id, 'invoice' => $request->no]);
        
        if (! $invoice instanceof Invoice) {
            Route::back('/customer');
        }
        
        $payment = Payment::firstOrFail(['order_id' => $invoice->order_id]);
        $orderItems = OrderItem::morphManyRaw("SELECT oi.*, p.title as product_title FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN orders o ON oi.order_id = o.id WHERE oi.order_id = :order_id AND o.user_id = :user", ['order_id' => $invoice->order_id, 'user' => auth()->id]);

        return view('customer.invoice', compact('invoice', 'orderItems', 'payment'))->output();
    }

    public function redeemProduct(Request $request)
    {
        if (! $request->pc_id || ! $request->ajax()) {
            Route::back('/customer');
        }

        $productCode = ProductCode::firstOrFail(['id' => $request->pc_id, 'user_id' => auth()->id]);
        $productCode->status = ProductCode::REDEEMED;
        $productCode->update();

        return json(['activation_code' => $productCode->activation_code]);
    }
}
