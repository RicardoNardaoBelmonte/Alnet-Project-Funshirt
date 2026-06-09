<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Price;
use App\Models\TshirtImage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TshirtController extends Controller
{
    public function index(Request $request): View
    {
        $query = TshirtImage::with('category')->whereNull('customer_id');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $tshirts    = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('tshirts.index', compact('tshirts', 'categories'));
    }

    public function show(TshirtImage $tshirt): View
    {
        if ($tshirt->customer_id !== null) {
            abort(404);
        }

        return view('tshirts.show', [
            'tshirt' => $tshirt->load('category'),
            'colors' => Color::all(),
            'price' => Price::current(),
            'sizes' => config('tshirt.sizes'),
        ]);
    }
}