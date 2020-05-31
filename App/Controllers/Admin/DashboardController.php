<?php

namespace App\Controllers\Admin;


use App\Core\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::rawFirst("SELECT count(*) as total FROM orders")->total;
        $orderProcessing = Order::rawFirst("SELECT count(*) as total FROM orders WHERE status = :status", ['status' => Order::PROCESSING])->total;
        $paymentsPending = Payment::rawFirst("SELECT count(*) as total FROM payments WHERE status = :status", ['status' => Payment::PENDING])->total;
        $recentOrders = Order::morphManyRaw("SELECT o.*, u.name, i.no, i.due_date FROM orders o JOIN invoices i ON i.order_id = o.id JOIN users u ON o.user_id = u.id ORDER BY o.created_at desc LIMIT 5");
        
        $incomes = Payment::raw('SELECT DATE_FORMAT(created_at, "%d/%m") as month, SUM(amount) as income FROM `payments` WHERE status = :status AND YEAR(created_at) = YEAR(CURRENT_DATE) GROUP BY created_at', ['status' => Payment::CONFIRMED]);
        $sales = Order::raw('SELECT count(*) as sales FROM orders WHERE status = :status AND YEAR(created_at) = YEAR(CURRENT_DATE) GROUP BY created_at', ['status' => Order::COMPLETED]);
        $bestProducts = Product::morphManyRaw("SELECT p.*, count(*) as sales FROM `order_items` oi JOIN products p ON oi.product_id = p.id JOIN orders o ON oi.order_id = o.id WHERE o.status = :status GROUP BY oi.product_id ORDER BY sales DESC LIMIT 5", ['status' => Order::COMPLETED]);

        view('admin.dashboard', compact('totalOrders', 'orderProcessing', 'paymentsPending', 'recentOrders', 'incomes', 'sales', 'bestProducts'))->output();
    }
}
