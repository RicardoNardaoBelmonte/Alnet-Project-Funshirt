<x-layouts::main-content :title="__('Users')"
    heading="Users"
    subheading="Manage all registered users">

    <div class="p-6">

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search by name or email…"
                class="flex-1 min-w-48 px-4 py-2.5 rounded-xl border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" />

            <select name="type"
                class="px-4 py-2.5 rounded-xl border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                <option value="">All types</option>
                <option value="C" {{ request('type') === 'C' ? 'selected' : '' }}>Customer</option>
                <option value="F" {{ request('type') === 'F' ? 'selected' : '' }}>Employee</option>
                <option value="A" {{ request('type') === 'A' ? 'selected' : '' }}>Admin</option>
            </select>

            <select name="status"
                class="px-4 py-2.5 rounded-xl border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                <option value="">All statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Blocked</option>
            </select>

            <flux:button type="submit" variant="primary">Search</flux:button>

            @if(request('search') || request('status') || request('type'))
                <flux:button variant="ghost" href="{{ route('admin.users.index') }}">Clear</flux:button>
            @endif
        </form>

        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ $users->total() }} {{ Str::plural('user', $users->total()) }}
                @if(request('search') || request('status') || request('type')) matching filters @endif
            </p>
        </div>

        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left w-10">#</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Registered</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @forelse($users as $user)
                        <tr class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <td class="px-4 py-3 text-zinc-400 font-mono text-xs">{{ $user->id }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->photo_full_url }}" alt="{{ $user->name }}"
                                        class="w-8 h-8 rounded-full object-cover flex-none" />
                                    <span class="font-semibold text-zinc-900 dark:text-white">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $typeLabels = ['A' => ['Admin', 'bg-purple-100 text-purple-700'], 'F' => ['Employee', 'bg-blue-100 text-blue-700'], 'C' => ['Customer', 'bg-zinc-100 text-zinc-700']];
                                    [$typeLabel, $typeClass] = $typeLabels[$user->user_type] ?? ['Unknown', 'bg-zinc-100 text-zinc-500'];
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $typeClass }}">{{ $typeLabel }}</span>
                            </td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                @if($user->blocked)
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">Blocked</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">Active</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    @if($user->blocked)
                                        <form action="{{ route('admin.users.unblock', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <flux:button size="sm" variant="ghost" type="submit">Unblock</flux:button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.block', $user) }}" method="POST"
                                            onsubmit="return confirm('Block {{ addslashes($user->name) }}? They will no longer be able to log in.')">
                                            @csrf
                                            @method('PATCH')
                                            <flux:button size="sm" variant="danger" type="submit">Block</flux:button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-16 text-center text-zinc-500 dark:text-zinc-400">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="mt-6">{{ $users->links() }}</div>
        @endif

    </div>

</x-layouts::main-content>