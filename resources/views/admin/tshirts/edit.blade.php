<x-layouts::main-content :title="__('Edit T-Shirt')"
    heading="Edit T-Shirt"
    subheading="Update the details of this catalogue t-shirt">

    <div class="p-6 max-w-2xl">

        <div class="mb-6">
            <a href="{{ route('admin.tshirts.index') }}"
                class="text-sm text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                ← Back to T-Shirts
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-8">
            <form action="{{ route('admin.tshirts.update', $tshirt) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                @csrf
                @method('PUT')

                @include('admin.tshirts.partials.form', ['tshirt' => $tshirt])

                <div class="flex gap-3 pt-2">
                    <flux:button type="submit" variant="primary" class="flex-1">Save Changes</flux:button>
                    <a href="{{ route('admin.tshirts.index') }}"
                        class="flex-none flex items-center justify-center px-6 py-2 rounded-lg border border-zinc-200 dark:border-zinc-600 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

    </div>

</x-layouts::main-content>
