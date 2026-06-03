<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Tshirt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopCartController extends Controller
{
    private function getCart(): array
    {
        return session('tshirt_cart', []);
    }

    private function saveCart(array $cart): void
    {
        session(['tshirt_cart' => $cart]);
    }

    private function cartKey(int $tshirtId, ?int $colorId, string $size): string
    {
        return "{$tshirtId}_".($colorId ?? 'none')."_{$size}";
    }

    public function show(): View
    {
        $cart = $this->getCart();

        $tshirtIds = array_unique(array_column($cart, 'tshirt_id'));
        $tshirts = $tshirtIds
            ? Tshirt::with('colors')->whereIn('id', $tshirtIds)->get()->keyBy('id')
            : collect();

        $colorIds = array_filter(array_unique(array_column($cart, 'color_id')));
        $colors = $colorIds
            ? Color::whereIn('id', $colorIds)->get()->keyBy('id')
            : collect();

        $total = array_sum(array_map(
            fn ($item) => $item['unit_price'] * $item['quantity'],
            $cart
        ));

        return view('shop.cart', compact('cart', 'tshirts', 'colors', 'total'));
    }

    public function add(Request $request, Tshirt $tshirt): RedirectResponse
    {
        $validated = $request->validate([
            'size' => ['required', 'string', 'in:'.implode(',', config('tshirt.sizes'))],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'color_id' => ['nullable', 'integer', 'exists:colors,id'],
        ]);

        if ($tshirt->customer_id !== null) {
            $customer = auth()->user()?->customer;
            if (! $customer || $tshirt->customer_id !== $customer->id) {
                abort(403);
            }
        }

        $size = $validated['size'];
        $colorId = isset($validated['color_id']) ? (int) $validated['color_id'] : null;
        $quantity = (int) $validated['quantity'];
        $key = $this->cartKey($tshirt->id, $colorId, $size);

        $cart = $this->getCart();

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = min(10, $cart[$key]['quantity'] + $quantity);
        } else {
            $cart[$key] = [
                'tshirt_id' => $tshirt->id,
                'color_id' => $colorId,
                'size' => $size,
                'quantity' => $quantity,
                'unit_price' => (float) $tshirt->price,
            ];
        }

        $this->saveCart($cart);

        return redirect()->route('shop.cart.show')
            ->with('alert-type', 'success')
            ->with('alert-msg', '"<strong>'.e($tshirt->name).'</strong>" added to your cart!');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $cart = $this->getCart();
        $key = $validated['key'];

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = (int) $validated['quantity'];
            $this->saveCart($cart);
        }

        return back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Cart updated.');
    }

    public function remove(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string'],
        ]);

        $cart = $this->getCart();
        unset($cart[$validated['key']]);

        if (empty($cart)) {
            session()->forget('tshirt_cart');
        } else {
            $this->saveCart($cart);
        }

        return back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Item removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        session()->forget('tshirt_cart');

        return back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shopping cart cleared.');
    }
}
