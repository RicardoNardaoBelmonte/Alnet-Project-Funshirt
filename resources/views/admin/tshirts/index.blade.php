<x-layouts::main-content :title="__('T-Shirts')"
    heading="Catalogue T-Shirts"
    subheading="Manage the t-shirts available in the public catalogue">

    <div class="p-6">

        {{-- ALERTS --}}
        @if(session('alert-msg'))
            <div class="mb-6">
                <flux:callout variant="{{ session('alert-type', 'info') }}">
                    <div>{!! session('alert-msg') !!}</div>
                </flux:callout>
            </div>
        @endif

        {{-- HEADER ROW --}}
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ $tshirts->total() }} {{ Str::plural('t-shirt', $tshirts->total()) }} total
            </p>
            <flux:button variant="primary" href="{{ route('admin.tshirts.create') }}" wire:navigate>
                + New T-Shirt
            </flux:button>
        </div>

        {{-- TABLE --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left w-16">Image</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Category</th>
                        <th class="px-4 py-3 text-left hidden md:table-cell">Description</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @forelse($tshirts as $tshirt)
                        <tr class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <td class="px-4 py-3">
                                <div class="w-12 h-12 rounded-lg overflow-hidden bg-zinc-100 dark:bg-zinc-700 flex-none">
                                    <img src="{{ $tshirt->image_url }}" alt="{{ $tshirt->name }}"
                                        class="w-full h-full object-cover" />
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-zinc-900 dark:text-white">{{ $tshirt->name }}</span>
                            </td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">
                                {{ $tshirt->category?->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400 hidden md:table-cell max-w-xs">
                                <span class="line-clamp-1">{{ $tshirt->description ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('tshirts.show', $tshirt) }}"
                                        class="text-xs text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors"
                                        target="_blank" title="View public page">
                                        View
                                    </a>
                                    <flux:button size="sm" variant="ghost"
                                        href="{{ route('admin.tshirts.edit', $tshirt) }}" wire:navigate>
                                        Edit
                                    </flux:button>
                                    <form action="{{ route('admin.tshirts.destroy', $tshirt) }}" method="POST"
                                        onsubmit="return confirm('Delete {{ addslashes($tshirt->name) }}? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button size="sm" variant="danger" type="submit">
                                            Delete
                                        </flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-16 text-center text-zinc-500 dark:text-zinc-400">
                                No t-shirts yet. <a href="{{ route('admin.tshirts.create') }}" class="text-amber-500 hover:underline">Create the first one.</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($tshirts->hasPages())
            <div class="mt-6">
                {{ $tshirts->links() }}
            </div>
        @endif

    </div>

</x-layouts::main-content>
