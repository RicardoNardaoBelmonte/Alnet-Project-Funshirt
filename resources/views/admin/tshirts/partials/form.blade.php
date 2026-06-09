{{-- Name --}}
<div>
    <flux:input
        name="name"
        label="Name"
        placeholder="e.g. Classic Black Tee"
        value="{{ old('name', $tshirt?->name) }}"
        required
    />
    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

{{-- Category --}}
<div>
    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">Category</label>
    <select name="category_id"
        class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm">
        <option value="">— No category —</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ old('category_id', $tshirt?->category_id) == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

{{-- Description --}}
<div>
    <flux:textarea
        name="description"
        label="Description (optional)"
        placeholder="Describe the design, style, or fit…"
        rows="3"
    >{{ old('description', $tshirt?->description) }}</flux:textarea>
    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

{{-- Image --}}
<div x-data="{ preview: '{{ $tshirt?->image_url }}', dragging: false }">
    <p class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
        Image @if(!$tshirt) <span class="text-red-500">*</span> @else <span class="text-zinc-400 font-normal">(leave empty to keep current)</span> @endif
    </p>

    @if($tshirt?->image_url)
        <div class="mb-3 w-24 h-24 rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-700">
            <img src="{{ $tshirt->image_url }}" alt="{{ $tshirt->name }}" class="w-full h-full object-cover" />
        </div>
    @endif

    <label
        for="tshirt-image"
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
                <div class="text-3xl mb-2">📁</div>
                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Click to upload or drag & drop</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">PNG, JPG, WEBP, GIF — max 4MB</p>
            </div>
        </template>
        <template x-if="preview">
            <div>
                <img :src="preview" class="max-h-40 mx-auto rounded-lg object-contain" />
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">Click to change image</p>
            </div>
        </template>
    </label>
    <input
        x-ref="fileInput"
        id="tshirt-image"
        type="file"
        name="image"
        accept="image/*"
        class="sr-only"
        x-on:change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : preview"
    />
    @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
