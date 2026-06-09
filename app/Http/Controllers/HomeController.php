<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TshirtImage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::all()->map(fn ($cat) => [
            'id'        => $cat->id,
            'name'      => $cat->name,
            'image_url' => $cat->image_url,
            'url'       => route('categories.show', $cat),
        ]);

        $base = TshirtImage::with('category')->whereNull('customer_id');

        $bestSellers = (clone $base)
            ->withCount(['orderItems as sold_qty' => function ($q) {
                $q->whereHas('order', fn ($q) => $q->where('status', 'closed'));
            }])
            ->orderByDesc('sold_qty')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $recentlyReleased = (clone $base)
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        return view('home', compact('categories', 'bestSellers', 'recentlyReleased'));
    }
}