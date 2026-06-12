<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    // mostra o histórico de encomendas do cliente autenticado
    public function index(): View
    {
        // o customer pode não existir se o utilizador nunca fez nada ainda
        $customer = auth()->user()->customer;

        $orders = $customer
            ? Order::where('customer_id', $customer->id)->latest()->paginate(10)->withQueryString()
            : collect();

        return view('my.orders.index', compact('orders'));
    }

    // mostra o detalhe de uma encomenda específica
    public function show(int $id): View
    {
        $order = Order::with('items.tshirtImage', 'items.color')->findOrFail($id);

        $customer = auth()->user()->customer;

        // garante que o cliente só vê as suas próprias encomendas
        if (! $customer || $order->customer_id !== $customer->id) {
            abort(403);
        }

        return view('my.orders.show', compact('order'));
    }
}
