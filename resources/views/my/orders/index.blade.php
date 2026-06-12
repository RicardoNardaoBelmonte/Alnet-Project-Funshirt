<x-layouts::app.header>

<div class="bg-zinc-50 dark:bg-zinc-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-12">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-4xl font-black text-zinc-900 dark:text-white">My Orders</h1>
            <p class="mt-2 text-zinc-500 dark:text-zinc-400">View the history of your orders.</p>
        </div>

        @if($orders->isEmpty())

            <div class="text-center py-24 bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">No orders yet</h2>
                <p class="text-zinc-500 dark:text-zinc-400 mb-8">You haven't placed any orders yet.</p>
                <a href="{{ route('tshirts.index') }}"
                    class="inline-block bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold py-3 px-8 rounded-full transition-colors">
                    Browse Catalogue
                </a>
            </div>

        @else

            <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Total</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                        @foreach($orders as $order)
                            <tr class="bg-white dark:bg-zinc-900">
                                <td class="px-4 py-3 font-mono text-zinc-500">#{{ $order->id }}</td>
                                <td class="px-4 py-3 text-zinc-500">
                                    {{ $order->date?->format('d/m/Y') ?? '—' }}
                                </td>
                                <td class="px-4 py-3 font-semibold text-zinc-900 dark:text-white">
                                    €{{ number_format($order->total_price, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $colors = [
                                            'pending'  => 'bg-amber-100 text-amber-700',
                                            'closed'   => 'bg-green-100 text-green-700',
                                            'canceled' => 'bg-red-100 text-red-700',
                                        ];
                                        $color = $colors[$order->status] ?? 'bg-zinc-100 text-zinc-700';
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $color }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('my.orders.show', $order) }}"
                                        class="text-xs text-amber-500 hover:text-amber-600 font-semibold">
                                        View →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>

        @endif

    </div>
</div>

</x-layouts::app.header>
