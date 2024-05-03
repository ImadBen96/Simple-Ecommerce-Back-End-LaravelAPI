<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products_numbers = Product::count();
        $categories_numbers = Category::count();
        $order_numbers = Order::count();
        $customer_numbers = User::count();

        return response()->json([
            "products" => $products_numbers,
            "categories" => $categories_numbers,
            "orders" => $order_numbers,
            "customers" => $customer_numbers,
        ]);
    }
    public function allCustomers()
    {
        $customers = User::where("id","!=",1)->get();
        return response()->json([
            "customers" => $customers,
        ]);
    }
    public function allOrders()
    {
        $orders = Order::all();
        return response()->json([
            "orders" => $orders,
        ]);
    }
}
