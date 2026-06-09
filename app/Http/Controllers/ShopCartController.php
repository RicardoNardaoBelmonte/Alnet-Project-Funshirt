<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Price;
use App\Models\TshirtImage;
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

    private function cartKey(int $tshirtId, string $colorCode, string $size): string
    {
        return "{$tshirtId}_{$colorCode}_{$size}";
    }

    public function show(): View
    {
        $cart = $this->getCart();

        $tshirtIds = array_unique(array_column($cart, 'tshirt_image_id'));
        $tshirts = $tshirtIds
            ? TshirtImage::whereIn('id', $tshirtIds)->get()->keyBy('id')
            : collect();

        $colorCodes = array_filter(array_unique(array_column($cart, 'color_code')));
        $colors = $colorCodes
            ? Color::whereIn('code', $colorCodes)->get()->keyBy('code')
            : collect();

        $total = array_sum(array_map(
            fn ($item) => $item['unit_price'] * $item['qty'],
            $cart
        ));

        return view('shop.cart', compact('cart', 'tshirts', 'colors', 'total'));
    }

    public function add(Request $request, TshirtImage $tshirt): RedirectResponse
    {
        $validated = $request->validate([
            'size'       => ['required', 'string', 'in:'.implode(',', config('tshirt.sizes'))],
            'qty'        => ['required', 'integer', 'min:1', 'max:99'],
            'color_code' => ['required', 'string', 'exists:colors,code'],
        ]);

        if ($tshirt->customer_id !== null) {
            $customer = auth()->user()?->customer;
            if (! $customer || $tshirt->customer_id !== $customer->id) {
                abort(403);
            }
        }

        $size      = $validated['size'];
        $colorCode = $validated['color_code'];
        $qty       = (int) $validated['qty'];
        $key       = $this->cartKey($tshirt->id, $colorCode, $size);

        $price     = Price::current();
        $unitPrice = $tshirt->customer_id === null
            ? (float) $price->unit_price_catalog
            : (float) $price->unit_price_own;

        $cart = $this->getCart();

        if (isset($cart[$key])) {
            $cart[$key]['qty'] = $cart[$key]['qty'] + $qty;
        } else {
            $cart[$key] = [
                'tshirt_image_id' => $tshirt->id,
                'color_code'      => $colorCode,
                'size'            => $size,
                'qty'             => $qty,
                'unit_price'      => $unitPrice,
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
            'qty' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $cart = $this->getCart();
        $key  = $validated['key'];
        $qty  = (int) $validated['qty'];

        if (isset($cart[$key])) {
            if ($qty === 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['qty'] = $qty;
            }
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