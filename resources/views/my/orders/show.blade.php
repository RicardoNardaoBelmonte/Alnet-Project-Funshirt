<x-layouts::app.header>

<div class="bg-white dark:bg-zinc-900 min-h-screen">

    {{-- BREADCRUMB --}}
    <div class="max-w-7xl mx-auto px-6 pt-8">
        <nav class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
            <a href="{{ route('home') }}" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Home</a>
            <span>→</span>
            <a href="{{ route('my.orders.index') }}" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Orders</a>
            <span>→</span>
            <span class="text-zinc-900 dark:text-white">#{{ $order->id }}</span>
        </nav>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col gap-8">

        {{-- ORDER SUMMARY --}}
        <div class="bg-zinc-50 dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
            <h1 class="text-2xl font-black text-zinc-900 dark:text-white mb-6">Order #{{ $order->id }}</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">

                <div>
                    <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1">Date</p>
                    <p class="text-zinc-900 dark:text-white font-semibold">
                        {{ $order->date?->format('d/m/Y') ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1">Status</p>
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
                </div>

                <div>
                    <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1">Total</p>
                    <p class="text-zinc-900 dark:text-white font-semibold">€{{ number_format($order->total_price, 2) }}</p>
                </div>

                <div>
                    <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1">Payment Type</p>
                    <p class="text-zinc-900 dark:text-white font-semibold">{{ $order->payment_type ?? '—' }}</p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1">Address</p>
                    <p class="text-zinc-900 dark:text-white font-semibold">{{ $order->address ?? '—' }}</p>
                </div>

                @if($order->notes)
                    <div class="sm:col-span-2 lg:col-span-3">
                        <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1">Notes</p>
                        <p class="text-zinc-900 dark:text-white font-semibold">{{ $order->notes }}</p>
                    </div>
                @endif

            </div>
        </div>

        {{-- ORDER ITEMS --}}
        <div>
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Items</h2>

            <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left">T-Shirt</th>
                            <th class="px-4 py-3 text-left">Colour</th>
                            <th class="px-4 py-3 text-left">Size</th>
                            <th class="px-4 py-3 text-left">Qty</th>
                            <th class="px-4 py-3 text-left">Unit Price</th>
                            <th class="px-4 py-3 text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                        @foreach($order->items as $item)
                            <tr class="bg-white dark:bg-zinc-900">
                                <td class="px-4 py-3 font-semibold text-zinc-900 dark:text-white">
                                    {{ $item->tshirtImage->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-zinc-500">
                                    {{ $item->color->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-zinc-500">{{ $item->size }}</td>
                                <td class="px-4 py-3 text-zinc-500">{{ $item->qty }}</td>
                                <td class="px-4 py-3 text-zinc-500">€{{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-4 py-3 font-semibold text-zinc-900 dark:text-white">
                                    €{{ number_format($item->sub_total, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</x-layouts::app.header>
