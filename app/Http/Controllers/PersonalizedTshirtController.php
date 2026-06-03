<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Tshirt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PersonalizedTshirtController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    private function resolveCustomer(): Customer
    {
        $user = auth()->user();

        if (! $user->customer) {
            $user->customer()->create([]);
            $user->load('customer');
        }

        return $user->customer;
    }

    private function authorizeOwner(Tshirt $tshirt): void
    {
        $customer = auth()->user()->customer;

        if (! $customer || $tshirt->customer_id !== $customer->id) {
            if (! auth()->user()->admin) {
                abort(403);
            }
        }
    }

    public function index(): View
    {
        $customer = auth()->user()->customer;

        $tshirts = $customer
            ? Tshirt::where('customer_id', $customer->id)->latest()->paginate(12)
            : collect();

        return view('tshirts.personalized.index', compact('tshirts'));
    }

    public function create(): View
    {
        return view('tshirts.personalized.create', [
            'personalized_price' => config('tshirt.personalized_price'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
        ]);

        $customer = $this->resolveCustomer();

        $path = Storage::disk('local')->putFile('personalizedtshirts', $request->file('image'));

        $tshirt = Tshirt::create([
            'customer_id' => $customer->id,
            'category_id' => null,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image_url' => $path,
            'price' => config('tshirt.personalized_price'),
        ]);

        return redirect()->route('my.tshirts.show', $tshirt)
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Personalized t-shirt created successfully!');
    }

    public function show(Tshirt $tshirt): View
    {
        $this->authorizeOwner($tshirt);

        return view('tshirts.personalized.show', [
            'tshirt' => $tshirt,
            'sizes' => config('tshirt.sizes'),
        ]);
    }

    public function edit(Tshirt $tshirt): View
    {
        $this->authorizeOwner($tshirt);

        return view('tshirts.personalized.edit', compact('tshirt'));
    }

    public function update(Request $request, Tshirt $tshirt): RedirectResponse
    {
        $this->authorizeOwner($tshirt);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($tshirt->image_url && Storage::disk('local')->exists($tshirt->image_url)) {
                Storage::disk('local')->delete($tshirt->image_url);
            }
            $validated['image_url'] = Storage::disk('local')->putFile('personalizedtshirts', $request->file('image'));
        }

        unset($validated['image']);
        $tshirt->update($validated);

        return redirect()->route('my.tshirts.show', $tshirt)
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Personalized t-shirt updated successfully!');
    }

    public function destroy(Tshirt $tshirt): RedirectResponse
    {
        $this->authorizeOwner($tshirt);

        if ($tshirt->image_url && Storage::disk('local')->exists($tshirt->image_url)) {
            Storage::disk('local')->delete($tshirt->image_url);
        }

        $tshirt->delete();

        return redirect()->route('my.tshirts.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Personalized t-shirt deleted.');
    }

    public function image(Tshirt $tshirt): StreamedResponse
    {
        $this->authorizeOwner($tshirt);

        if (! $tshirt->image_url || ! Storage::disk('local')->exists($tshirt->image_url)) {
            abort(404);
        }

        return Storage::disk('local')->response($tshirt->image_url);
    }
}
