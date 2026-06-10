<x-layouts::main-content :title="__('New Color')"
    heading="New Color"
    subheading="Add a new color to the t-shirt palette">

    <div class="p-6 max-w-md">

        <div class="mb-6">
            <a href="{{ route('admin.colors.index') }}"
                class="text-sm text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                ← Back to Colors
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-8">
            <form action="{{ route('admin.colors.store') }}" method="POST" class="flex flex-col gap-6"
                x-data="{ code: '{{ old('code', '#000000') }}' }">
                @csrf

                <div>
                    <flux:input
                        name="name"
                        label="Name"
                        placeholder="e.g. Navy Blue"
                        value="{{ old('name') }}"
                        required
                    />
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                        Color Code <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                        Any valid CSS color — a hex value like <code>#1e3a5f</code>, a name like <code>navy</code>, or <code>rgb()</code>.
                    </p>
                    <div class="flex items-center gap-3">
                        <input type="color" x-model="code"
                            class="w-10 h-10 rounded-lg border border-zinc-200 dark:border-zinc-600 cursor-pointer p-0.5 bg-white dark:bg-zinc-700" />
                        <input type="text" name="code" x-model="code"
                            placeholder="#000000"
                            class="flex-1 px-4 py-2.5 rounded-xl border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm font-mono"
                            required />
                    </div>
                    @error('code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <flux:button type="submit" variant="primary" class="flex-1">Create Color</flux:button>
                    <a href="{{ route('admin.colors.index') }}"
                        class="flex-none flex items-center justify-center px-6 py-2 rounded-lg border border-zinc-200 dark:border-zinc-600 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

    </div>

</x-layouts::main-content>