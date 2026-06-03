<x-layouts::app.header>

<div class="bg-zinc-50 dark:bg-zinc-900 min-h-screen">
    <div class="max-w-2xl mx-auto px-6 py-12">

        {{-- HEADER --}}
        <div class="mb-8">
            <a href="{{ route('my.tshirts.show', $tshirt) }}" class="text-sm text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                ← Back to Design
            </a>
            <h1 class="mt-4 text-3xl font-black text-zinc-900 dark:text-white">Edit Design</h1>
        </div>

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

            <form action="{{ route('my.tshirts.update', $tshirt) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                @csrf
                @method('PUT')

                {{-- CURRENT IMAGE --}}
                <div>
                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">Current Image</label>
                    <div class="w-32 h-32 rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-700 mb-3">
                        <img src="{{ route('my.tshirts.image', $tshirt) }}" alt="{{ $tshirt->name }}" class="w-full h-full object-cover" />
                    </div>
                </div>

                {{-- NEW IMAGE --}}
                <div x-data="{ preview: null, dragging: false }">
                    <p class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">Replace Image (optional)</p>
                    <label
                        for="replace-image"
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
                        class="border-2 border-dashed rounded-xl p-5 text-center transition-colors cursor-pointer block"
                    >
                        <template x-if="!preview">
                            <div>
                                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Click to upload a new image</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">PNG, JPG, WEBP, GIF — max 4MB</p>
                            </div>
                        </template>
                        <template x-if="preview">
                            <div>
                                <img :src="preview" class="max-h-36 mx-auto rounded-lg object-contain" />
                                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">Click to change</p>
                            </div>
                        </template>
                    </label>
                    <input
                        x-ref="fileInput"
                        id="replace-image"
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
                        value="{{ old('name', $tshirt->name) }}"
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
                        rows="3"
                    >{{ old('description', $tshirt->description) }}</flux:textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ACTIONS --}}
                <div class="flex gap-3 pt-2">
                    <flux:button type="submit" variant="primary" class="flex-1">
                        Save Changes
                    </flux:button>
                    <a href="{{ route('my.tshirts.show', $tshirt) }}"
                        class="flex-none flex items-center justify-center px-6 py-2 rounded-lg border border-zinc-200 dark:border-zinc-600 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

</x-layouts::app.header>
