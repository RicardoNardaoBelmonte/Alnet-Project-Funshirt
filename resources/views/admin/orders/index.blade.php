<x-layouts::main-content :title="__('Orders')"
    heading="Orders"
    subheading="All customer orders">

    <div class="p-6">

        @if($orders->isEmpty())
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-10 text-center">
                <p class="text-zinc-500 dark:text-zinc-400 text-sm">No orders yet.</p>
            </div>
        @else
            <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Customer</th>
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
                                <td class="px-4 py-3 font-semibold text-zinc-900 dark:text-white">
                                    {{ $order->customer->user->name ?? '—' }}
                                </td>
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
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="text-xs text-amber-500 hover:text-amber-600 font-semibold">
                                        View →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif

    </div>

</x-layouts::main-content>
