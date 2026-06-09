<x-layouts::app.header>

<div class="bg-zinc-50 dark:bg-zinc-900 min-h-screen">
    <div class="max-w-2xl mx-auto px-6 py-12">

        {{-- HEADER --}}
        <div class="mb-8">
            <a href="{{ route('my.tshirts.index') }}" class="text-sm text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                ← My Designs
            </a>
            <h1 class="mt-4 text-3xl font-black text-zinc-900 dark:text-white">Upload Your Design</h1>
            <p class="mt-2 text-zinc-500 dark:text-zinc-400">Upload an image and we'll print it on a t-shirt.</p>
        </div>

        {{-- PRICE INFO --}}
        <div class="mb-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4 flex items-start gap-3">
            <span class="text-amber-500 text-xl">💡</span>
            <div>
                <p class="font-semibold text-amber-700 dark:text-amber-400 text-sm">Personalized price</p>
                <p class="text-amber-700 dark:text-amber-300 text-sm mt-0.5">
                    Each personalized t-shirt starts at <strong>€{{ number_format($price->unit_price_own, 2) }}</strong> — your design, your style.
                </p>
            </div>
        </div>

        {{-- FORM --}}
        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-8">

            @if($errors->any())
                <div class="mb-6">
                    <flux:callout variant="warning" icon="exclamation-circle">
                        <div>
                            <p class="font-semibold">Please fix the following errors:</p>
                            <ul class="mt-1 list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </flux:callout>
                </div>
            @endif

            <form action="{{ route('my.tshirts.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                @csrf

                {{-- IMAGE UPLOAD --}}
                <div x-data="{ preview: null, dragging: false }">
                    <p class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                        Design Image <span class="text-red-500">*</span>
                    </p>
                    {{-- label[for] is the reliable cross-browser way to open a file dialog --}}
                    <label
                        for="design-image"
                        x-on:dragover.prevent="dragging = true"
                        x-on:dragleave.prevent="dragging = false"
                        x-on:drop.prevent="
                            dragging = false;
                            const f = $event.dataTransfer.files[0];
                            if (f) {
                                preview = URL.createObjectURL(f);
                                const dt = new DataTransfer();
                                dt.items.add(f);
                                $refs.fileInput.files = dt.files;
                            }
                        "
                        :class="dragging ? 'border-amber-400 bg-amber-50 dark:bg-amber-900/10' : 'border-zinc-300 dark:border-zinc-600 bg-zinc-50 dark:bg-zinc-700'"
                        class="border-2 border-dashed rounded-xl p-6 text-center transition-colors cursor-pointer block"
                    >
                        <template x-if="!preview">
                            <div>
                                <div class="text-4xl mb-2">📁</div>
                                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Click to upload or drag & drop</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">PNG, JPG, WEBP, GIF — max 4MB</p>
                            </div>
                        </template>
                        <template x-if="preview">
                            <div>
                                <img :src="preview" class="max-h-48 mx-auto rounded-lg object-contain" />
                                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">Click to change image</p>
                            </div>
                        </template>
                    </label>
                    {{-- input must be INSIDE x-data so $refs.fileInput is in scope --}}
                    <input
                        x-ref="fileInput"
                        id="design-image"
                        type="file"
                        name="image"
                        accept="image/*"
                        class="sr-only"
                        x-on:change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                    />
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NAME --}}
                <div>
                    <flux:input
                        name="name"
                        label="Design Name"
                        placeholder="e.g. My Summer Design"
                        value="{{ old('name') }}"
                        required
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <flux:textarea
                        name="description"
                        label="Description (optional)"
                        placeholder="Describe your design or any special instructions..."
                        rows="3"
                    >{{ old('description') }}</flux:textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PRICE DISPLAY --}}
                <div class="flex items-center justify-between py-4 border-t border-zinc-100 dark:border-zinc-700">
                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Price per unit</span>
                    <span class="text-xl font-black text-amber-500 dark:text-amber-400">€{{ number_format($price->unit_price_own, 2) }}</span>
                </div>

                {{-- ACTIONS --}}
                <div class="flex gap-3">
                    <flux:button type="submit" variant="primary" class="flex-1">
                        Create Design
                    </flux:button>
                    <a href="{{ route('my.tshirts.index') }}"
                        class="flex-none flex items-center justify-center px-6 py-2 rounded-lg border border-zinc-200 dark:border-zinc-600 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

</x-layouts::app.header>
