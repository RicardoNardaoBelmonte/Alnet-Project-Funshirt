<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminCategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('tshirtImages')->orderBy('name')->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255', 'unique:categories,name'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path     = Storage::disk('public')->putFile('category_images', $request->file('image'));
            $imageUrl = Storage::disk('public')->url($path);
        }

        Category::create([
            'name'      => $validated['name'],
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Category <strong>{$validated['name']}</strong> created successfully!");
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255', 'unique:categories,name,'.$category->id],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $this->deleteStoredImage($category->image_url);
            $path                   = Storage::disk('public')->putFile('category_images', $request->file('image'));
            $validated['image_url'] = Storage::disk('public')->url($path);
        }

        unset($validated['image']);
        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Category <strong>{$category->name}</strong> updated successfully!");
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->tshirtImages()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('alert-type', 'warning')
                ->with('alert-msg', "Category <strong>{$category->name}</strong> cannot be deleted because it still has t-shirts assigned to it.");
        }

        $name = $category->name;
        $this->deleteStoredImage($category->image_url);
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Category <strong>{$name}</strong> deleted.");
    }

    private function deleteStoredImage(?string $imageUrl): void
    {
        if (! $imageUrl) {
            return;
        }
        $publicPath = parse_url($imageUrl, PHP_URL_PATH);
        $relative   = ltrim(str_replace('/storage/', '', $publicPath), '/');
        if ($relative && Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->delete($relative);
        }
    }
}
