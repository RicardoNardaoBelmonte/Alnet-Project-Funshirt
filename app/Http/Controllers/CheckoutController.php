<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Notifications\OrderCheckoutNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Show the checkout form with address/billing info.
     */
    public function show(): View|RedirectResponse
    {
        // Verify user is authenticated
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        // Get or create customer record
        $customer = $user->customer;
        if (! $customer) {
            // Create customer record on-the-fly if missing
            $customer = Customer::create([
                'id' => $user->id,
            ]);
        }

        // Verify customer has address configured
        if (! $customer->address) {
            return redirect()->route('address.edit')
                ->with('alert-msg', 'Please configure your billing address to complete checkout.')
                ->with('alert-type', 'warning');
        }

        // Get cart from session
        $cart = session('tshirt_cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.cart.show')
                ->with('alert-msg', 'Your cart is empty.')
                ->with('alert-type', 'warning');
        }

        // Calculate totals
        $total = array_sum(array_map(
            fn ($item) => $item['unit_price'] * $item['qty'],
            $cart
        ));

        return view('shop.checkout', [
            'customer' => $customer,
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    /**
     * Process the checkout and create the order.
     */
    public function store(Request $request): RedirectResponse
    {
        // Verify user is authenticated
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login')
                ->with('alert-msg', 'Please log in to complete your order.')
                ->with('alert-type', 'warning');
        }

        // Get or create customer
        $customer = $user->customer;
        if (! $customer) {
            $customer = Customer::create([
                'id' => $user->id,
            ]);
        }

        // Verify address is configured
        if (! $customer->address) {
            return redirect()->route('address.edit')
                ->with('alert-msg', 'Please configure your billing address to complete checkout.')
                ->with('alert-type', 'error');
        }

        // Validate checkout form
        $validated = $request->validate([
            'payment_type' => ['required', 'string', 'in:card,bank_transfer,cash'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        // Get cart from session
        $cart = session('tshirt_cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.cart.show')
                ->with('alert-msg', 'Your cart is empty.')
                ->with('alert-type', 'warning');
        }

        // Calculate total
        $total = array_sum(array_map(
            fn ($item) => $item['unit_price'] * $item['qty'],
            $cart
        ));

        // Create order
        $order = Order::create([
            'customer_id' => $customer->id,
            'status' => 'pending',
            'date' => now()->toDateString(),
            'total_price' => $total,
            'nif' => $customer->nif,
            'address' => $customer->address,
            'payment_type' => $validated['payment_type'],
            'payment_ref' => $request->input('payment_ref') ?? '',
            'notes' => $validated['notes'] ?? null,
            'custom' => false,
        ]);

        // Create order items from cart
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'tshirt_image_id' => $item['tshirt_image_id'],
                'color_code' => $item['color_code'],
                'size' => $item['size'],
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'sub_total' => $item['unit_price'] * $item['qty'],
            ]);
        }

        // Send confirmation email
        $user->notify(new OrderCheckoutNotification($order));

        // Clear cart
        session()->forget('tshirt_cart');

        // Redirect with success message
        return redirect()->route('my.orders.index')
            ->with('alert-msg', 'Order created successfully! Check your email for the confirmation.')
            ->with('alert-type', 'success');
    }
}
