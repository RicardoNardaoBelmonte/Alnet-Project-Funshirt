<x-layouts::main-content :title="__('Colors')"
    heading="Colors"
    subheading="Manage the colors available for t-shirts">

    <div class="p-6">

        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ $colors->total() }} {{ Str::plural('color', $colors->total()) }} total
            </p>
            <flux:button variant="primary" href="{{ route('admin.colors.create') }}" wire:navigate>
                + New Color
            </flux:button>
        </div>

        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left w-16">Swatch</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Code</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @forelse($colors as $color)
                        <tr class="{{ $color->trashed() ? 'opacity-50' : '' }} bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <td class="px-4 py-3">
                                <div class="w-8 h-8 rounded-lg border border-zinc-200 dark:border-zinc-600"
                                    style="background-color: {{ $color->code }};"></div>
                            </td>
                            <td class="px-4 py-3 font-semibold text-zinc-900 dark:text-white">
                                {{ $color->name }}
                            </td>
                            <td class="px-4 py-3 font-mono text-zinc-500 dark:text-zinc-400 text-xs">
                                {{ $color->code }}
                            </td>
                            <td class="px-4 py-3">
                                @if($color->trashed())
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">Deleted</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">Active</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    @if($color->trashed())
                                        <form action="{{ route('admin.colors.restore', $color->code) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <flux:button size="sm" variant="ghost" type="submit">Restore</flux:button>
                                        </form>
                                    @else
                                        <flux:button size="sm" variant="ghost"
                                            href="{{ route('admin.colors.edit', $color) }}" wire:navigate>
                                            Edit
                                        </flux:button>
                                        <form action="{{ route('admin.colors.destroy', $color) }}" method="POST"
                                            onsubmit="return confirm('Delete color {{ addslashes($color->name) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button size="sm" variant="danger" type="submit">Delete</flux:button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-16 text-center text-zinc-500 dark:text-zinc-400">
                                No colors yet. <a href="{{ route('admin.colors.create') }}" class="text-amber-500 hover:underline">Add the first one.</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($colors->hasPages())
            <div class="mt-6">{{ $colors->links() }}</div>
        @endif

    </div>

</x-layouts::main-content>
