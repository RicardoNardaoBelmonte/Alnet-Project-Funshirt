<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(): View
    {
        // carrega o nome do cliente via relação customer → user
        $orders = Order::with('customer.user')->latest()->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        // carrega tudo de uma vez para evitar N+1 queries
        $order->load('items.tshirtImage', 'items.color', 'customer.user');

        return view('admin.orders.show', compact('order'));
    }

    public function close(Order $order): RedirectResponse
    {
        $order->update(['status' => 'closed']);

        return redirect()->route('admin.orders.show', $order)
            ->with('alert-type', 'success')
            ->with('alert-msg', "Order <strong>#{$order->id}</strong> has been marked as closed.");
    }

    public function cancel(Request $request, Order $order): RedirectResponse
    {
        // o motivo de cancelamento é opcional
        $validated = $request->validate([
            'reason_for_cancellation' => ['nullable', 'string', 'max:500'],
        ]);

        $order->update([
            'status'                  => 'canceled',
            'reason_for_cancellation' => $validated['reason_for_cancellation'] ?? null,
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('alert-type', 'success')
            ->with('alert-msg', "Order <strong>#{$order->id}</strong> has been canceled.");
    }
}
