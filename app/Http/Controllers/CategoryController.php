<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            'categories' => Category::withCount('tshirts')->get(),
        ]);
    }

    public function show(Category $category)
    {
        return view('categories.show', [
            'category' => $category,
            'tshirts' => $category->tshirts()->with('colors')->get(),
        ]);
    }
}
