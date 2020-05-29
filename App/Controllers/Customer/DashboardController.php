<?php

namespace App\Controllers\Customer;


use App\Core\Route;
use App\Core\Request;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\OrderItem;
use App\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() 
    {
        Product::raw("SELECT id FROM products");
        $totalProductInStore = Product::DB()->count();
        
        Product::raw("SELECT id FROM product_codes WHERE user_id = :user", ['user' => auth()->id]);
        $totalGameOwned = Product::DB()->count();

        $orders = Order::morphManyRaw("SELECT o.*, i.no, i.due_date, i.title, p.status as payment_status FROM orders o JOIN invoices i ON o.id = i.order_id JOIN payments p ON p.order_id = o.id WHERE o.user_id = :user ORDER BY o.created_at DESC", ['user' => auth()->id]);
        // ev($orders);
        return view('customer.dashboard', compact('totalProductInStore', 'totalGameOwned', 'orders'))->output();
    }

    public function invoice(Request $request)
    {
        $request->validate(['no' => 'required']);

        if (! $request->no) {
            Route::back('/customer');
        }

        // $invoice = Invoice::firstOrFail(['no' => $request->no, 'user_id' => auth()->id]);
        $invoice = Invoice::morphRaw("SELECT i.*, p.bank_name, p.bank_number, o.created_at as order_date FROM invoices i JOIN orders o ON i.order_id = o.id JOIN payments p ON p.order_id = o.id WHERE o.user_id = :user AND i.no = :invoice", ['user' => auth()->id, 'invoice' => $request->no]);
        
        if (! $invoice instanceof Invoice) {
            Route::back('/customer');
        }

        $orderItems = OrderItem::morphManyRaw("SELECT o.*, p.title as product_title FROM order_items o JOIN products p ON o.product_id = p.id WHERE order_id = :order_id", ['order_id' => $invoice->order_id]);

        return view('customer.invoice', compact('invoice', 'orderItems'))->output();
    }
}
