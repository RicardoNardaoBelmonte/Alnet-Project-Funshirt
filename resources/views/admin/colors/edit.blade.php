<x-layouts::main-content :title="__('Edit Color')"
    heading="Edit Color"
    subheading="Update the name of this color">

    <div class="p-6 max-w-md">

        <div class="mb-6">
            <a href="{{ route('admin.colors.index') }}"
                class="text-sm text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                ← Back to Colors
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-8">
            <form action="{{ route('admin.colors.update', $color) }}" method="POST" class="flex flex-col gap-6">
                @csrf
                @method('PUT')

                {{-- Preview --}}
                <div class="flex items-center gap-4 p-4 bg-zinc-50 dark:bg-zinc-700 rounded-xl">
                    <div class="w-12 h-12 rounded-xl border border-zinc-200 dark:border-zinc-600 flex-none"
                        style="background-color: {{ $color->code }};"></div>
                    <div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-0.5">Code (read-only)</p>
                        <p class="font-mono text-sm text-zinc-900 dark:text-white font-semibold">{{ $color->code }}</p>
                    </div>
                </div>

                <div>
                    <flux:input
                        name="name"
                        label="Name"
                        value="{{ old('name', $color->name) }}"
                        required
                    />
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <flux:button type="submit" variant="primary" class="flex-1">Save Changes</flux:button>
                    <a href="{{ route('admin.colors.index') }}"
                        class="flex-none flex items-center justify-center px-6 py-2 rounded-lg border border-zinc-200 dark:border-zinc-600 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

    </div>

</x-layouts::main-content>
