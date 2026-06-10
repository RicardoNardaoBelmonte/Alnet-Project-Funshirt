<x-layouts::main-content :title="__('Dashboard')"
    heading="Dashboard"
    subheading="Overview of your FunShirt store">

    <div class="p-6 flex flex-col gap-8">

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">

            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-2">Catalogue T-Shirts</p>
                <p class="text-4xl font-black text-zinc-900 dark:text-white">{{ $totalTshirts }}</p>
                <a href="{{ route('admin.tshirts.index') }}" class="mt-3 inline-block text-xs text-amber-500 hover:text-amber-600 font-semibold">
                    Manage →
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-2">Categories</p>
                <p class="text-4xl font-black text-zinc-900 dark:text-white">{{ $totalCategories }}</p>
                <a href="{{ route('admin.categories.index') }}" class="mt-3 inline-block text-xs text-amber-500 hover:text-amber-600 font-semibold">
                    Manage →
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-2">Colors</p>
                <p class="text-4xl font-black text-zinc-900 dark:text-white">{{ $totalColors }}</p>
                <a href="{{ route('admin.colors.index') }}" class="mt-3 inline-block text-xs text-amber-500 hover:text-amber-600 font-semibold">
                    Manage →
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-2">Users</p>
                <p class="text-4xl font-black text-zinc-900 dark:text-white">{{ $totalUsers }}</p>
                <a href="{{ route('admin.users.index') }}" class="mt-3 inline-block text-xs text-amber-500 hover:text-amber-600 font-semibold">
                    Manage →
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-2">Total Orders</p>
                <p class="text-4xl font-black text-zinc-900 dark:text-white">{{ $totalOrders }}</p>
                @if($pendingOrders > 0)
                    <p class="mt-2 text-xs font-semibold text-amber-500">{{ $pendingOrders }} pending</p>
                @endif
            </div>

        </div>

        {{-- QUICK ACTIONS --}}
        <div>
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <a href="{{ route('admin.tshirts.create') }}"
                    class="flex items-center gap-4 bg-amber-400 hover:bg-amber-300 text-zinc-900 rounded-2xl p-5 transition-colors group">
                    <div class="w-10 h-10 bg-zinc-900/10 rounded-xl flex items-center justify-center flex-none">
                        <flux:icon.plus class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="font-bold text-sm">Add T-Shirt</p>
                        <p class="text-xs text-zinc-700">Add a new design to the catalogue</p>
                    </div>
                </a>

                <a href="{{ route('admin.tshirts.index') }}"
                    class="flex items-center gap-4 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white rounded-2xl p-5 transition-colors">
                    <div class="w-10 h-10 bg-zinc-100 dark:bg-zinc-700 rounded-xl flex items-center justify-center flex-none">
                        <flux:icon.shopping-bag class="w-5 h-5 text-zinc-600 dark:text-zinc-300" />
                    </div>
                    <div>
                        <p class="font-bold text-sm">Manage T-Shirts</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Edit or delete catalogue designs</p>
                    </div>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-4 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white rounded-2xl p-5 transition-colors">
                    <div class="w-10 h-10 bg-zinc-100 dark:bg-zinc-700 rounded-xl flex items-center justify-center flex-none">
                        <flux:icon.tag class="w-5 h-5 text-zinc-600 dark:text-zinc-300" />
                    </div>
                    <div>
                        <p class="font-bold text-sm">Manage Categories</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Add, edit or remove categories</p>
                    </div>
                </a>

                <a href="{{ route('admin.colors.index') }}"
                    class="flex items-center gap-4 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white rounded-2xl p-5 transition-colors">
                    <div class="w-10 h-10 bg-zinc-100 dark:bg-zinc-700 rounded-xl flex items-center justify-center flex-none">
                        <flux:icon.swatch class="w-5 h-5 text-zinc-600 dark:text-zinc-300" />
                    </div>
                    <div>
                        <p class="font-bold text-sm">Manage Colors</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Add, edit or remove t-shirt colors</p>
                    </div>
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-4 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white rounded-2xl p-5 transition-colors">
                    <div class="w-10 h-10 bg-zinc-100 dark:bg-zinc-700 rounded-xl flex items-center justify-center flex-none">
                        <flux:icon.users class="w-5 h-5 text-zinc-600 dark:text-zinc-300" />
                    </div>
                    <div>
                        <p class="font-bold text-sm">Manage Users</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Block or unblock user accounts</p>
                    </div>
                </a>

                <a href="{{ route('tshirts.index') }}"
                    class="flex items-center gap-4 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white rounded-2xl p-5 transition-colors">
                    <div class="w-10 h-10 bg-zinc-100 dark:bg-zinc-700 rounded-xl flex items-center justify-center flex-none">
                        <flux:icon.eye class="w-5 h-5 text-zinc-600 dark:text-zinc-300" />
                    </div>
                    <div>
                        <p class="font-bold text-sm">View Public Shop</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">See the store as customers see it</p>
                    </div>
                </a>

            </div>
        </div>

        {{-- RECENT ORDERS --}}
        <div>
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Recent Orders</h2>

            @if($recentOrders->isEmpty())
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
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                            @foreach($recentOrders as $order)
                                <tr class="bg-white dark:bg-zinc-900">
                                    <td class="px-4 py-3 font-mono text-zinc-500">#{{ $order->id }}</td>
                                    <td class="px-4 py-3 font-semibold text-zinc-900 dark:text-white">
                                        {{ $order->customer->user->name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-zinc-500">{{ $order->date }}</td>
                                    <td class="px-4 py-3 font-semibold text-zinc-900 dark:text-white">
                                        €{{ number_format($order->total_price, 2) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $colors = ['pending' => 'bg-amber-100 text-amber-700', 'paid' => 'bg-blue-100 text-blue-700', 'shipped' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700'];
                                            $color = $colors[$order->status] ?? 'bg-zinc-100 text-zinc-700';
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $color }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

</x-layouts::main-content>
