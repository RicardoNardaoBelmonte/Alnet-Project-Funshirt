<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            'categories' => Category::withCount('tshirtImages')->get(),
        ]);
    }

    public function show(Category $category)
    {
        return view('categories.show', [
            'category' => $category,
            'tshirts'  => $category->tshirtImages()->whereNull('customer_id')->with('category')->latest()->paginate(12),
        ]);
    }
}