<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\TshirtImage;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'totalTshirts' => TshirtImage::whereNull('customer_id')->count(),
            'totalCategories' => Category::count(),
            'totalColors' => Color::count(),
            'totalUsers' => User::count(),
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'recentOrders' => Order::with('customer.user')->latest()->take(5)->get(),
        ]);
    }
}
