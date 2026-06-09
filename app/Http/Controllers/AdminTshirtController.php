<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TshirtImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminTshirtController extends Controller
{
    public function index(): View
    {
        $tshirts = TshirtImage::with('category')
            ->whereNull('customer_id')
            ->latest()
            ->paginate(15);

        return view('admin.tshirts.index', compact('tshirts'));
    }

    public function create(): View
    {
        return view('admin.tshirts.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'image'       => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
        ]);

        $path     = Storage::disk('public')->putFile('tshirt_images', $request->file('image'));
        $imageUrl = Storage::disk('public')->url($path);

        TshirtImage::create([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
            'image_url'   => $imageUrl,
        ]);

        return redirect()->route('admin.tshirts.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "T-shirt <strong>{$validated['name']}</strong> created successfully!");
    }

    public function edit(TshirtImage $tshirt): View
    {
        return view('admin.tshirts.edit', [
            'tshirt'     => $tshirt,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, TshirtImage $tshirt): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $this->deleteStoredImage($tshirt->image_url);
            $path                 = Storage::disk('public')->putFile('tshirt_images', $request->file('image'));
            $validated['image_url'] = Storage::disk('public')->url($path);
        }

        unset($validated['image']);
        $tshirt->update($validated);

        return redirect()->route('admin.tshirts.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "T-shirt <strong>{$tshirt->name}</strong> updated successfully!");
    }

    public function destroy(TshirtImage $tshirt): RedirectResponse
    {
        $name = $tshirt->name;
        $this->deleteStoredImage($tshirt->image_url);
        $tshirt->delete();

        return redirect()->route('admin.tshirts.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "T-shirt <strong>{$name}</strong> deleted.");
    }

    private function deleteStoredImage(?string $imageUrl): void
    {
        if (! $imageUrl) {
            return;
        }
        // Only delete files we stored locally (not external URLs like Unsplash)
        $publicPath = parse_url($imageUrl, PHP_URL_PATH);
        $relative   = ltrim(str_replace('/storage/', '', $publicPath), '/');
        if ($relative && Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->delete($relative);
        }
    }
}
