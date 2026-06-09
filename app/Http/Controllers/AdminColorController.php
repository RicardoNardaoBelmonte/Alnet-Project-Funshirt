<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminColorController extends Controller
{
    public function index(): View
    {
        $colors = Color::withTrashed()->orderBy('name')->paginate(20);

        return view('admin.colors.index', compact('colors'));
    }

    public function create(): View
    {
        return view('admin.colors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:colors,code'],
            'name' => ['required', 'string', 'max:255', 'unique:colors,name'],
        ]);

        Color::create($validated);

        return redirect()->route('admin.colors.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Color <strong>{$validated['name']}</strong> created successfully!");
    }

    public function edit(Color $color): View
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:colors,name,'.$color->code.',code'],
        ]);

        $color->update($validated);

        return redirect()->route('admin.colors.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Color <strong>{$color->name}</strong> updated successfully!");
    }

    public function destroy(Color $color): RedirectResponse
    {
        if ($color->orderItems()->exists()) {
            return redirect()->route('admin.colors.index')
                ->with('alert-type', 'warning')
                ->with('alert-msg', "Color <strong>{$color->name}</strong> cannot be deleted because it is used in existing orders.");
        }

        $color->delete();

        return redirect()->route('admin.colors.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Color <strong>{$color->name}</strong> deleted.");
    }

    public function restore(string $code): RedirectResponse
    {
        $color = Color::withTrashed()->findOrFail($code);
        $color->restore();

        return redirect()->route('admin.colors.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Color <strong>{$color->name}</strong> restored.");
    }
}
