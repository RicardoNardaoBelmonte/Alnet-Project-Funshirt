<x-layouts::main-content :title="__('Categories')"
    heading="Categories"
    subheading="Manage the t-shirt categories available in the shop">

    <div class="p-6">

        @if(session('alert-msg'))
            <div class="mb-6">
                <flux:callout variant="{{ session('alert-type', 'info') }}">
                    <div>{!! session('alert-msg') !!}</div>
                </flux:callout>
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ $categories->total() }} {{ Str::plural('category', $categories->total()) }} total
            </p>
            <flux:button variant="primary" href="{{ route('admin.categories.create') }}" wire:navigate>
                + New Category
            </flux:button>
        </div>

        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left w-16">Image</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">T-Shirts</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @forelse($categories as $category)
                        <tr class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <td class="px-4 py-3">
                                <div class="w-12 h-12 rounded-lg overflow-hidden bg-zinc-100 dark:bg-zinc-700 flex-none">
                                    @if($category->image_url)
                                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                            class="w-full h-full object-cover" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-zinc-400 text-lg">📁</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 font-semibold text-zinc-900 dark:text-white">
                                {{ $category->name }}
                            </td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">
                                <a href="{{ route('categories.show', $category) }}"
                                    class="hover:text-amber-500 transition-colors">
                                    {{ $category->tshirt_images_count }} {{ Str::plural('design', $category->tshirt_images_count) }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button size="sm" variant="ghost"
                                        href="{{ route('admin.categories.edit', $category) }}" wire:navigate>
                                        Edit
                                    </flux:button>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('Delete {{ addslashes($category->name) }}?{{ $category->tshirt_images_count > 0 ? " This category has " . $category->tshirt_images_count . " t-shirt(s) assigned." : "" }}')">
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
                            <td colspan="4" class="px-4 py-16 text-center text-zinc-500 dark:text-zinc-400">
                                No categories yet. <a href="{{ route('admin.categories.create') }}" class="text-amber-500 hover:underline">Create the first one.</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="mt-6">{{ $categories->links() }}</div>
        @endif

    </div>

</x-layouts::main-content>
