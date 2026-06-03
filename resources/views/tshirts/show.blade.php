<x-layouts::app.header>

<div class="bg-white dark:bg-zinc-900 min-h-screen">

    {{-- BREADCRUMB --}}
    <div class="max-w-7xl mx-auto px-6 pt-8">
        <nav class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
            <a href="{{ route('home') }}" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Home</a>
            <span>→</span>
            @if($tshirt->category)
                <a href="{{ route('categories.show', $tshirt->category) }}" class="hover:text-zinc-900 dark:hover:text-white transition-colors">
                    {{ $tshirt->category }}
                </a>
                <span>→</span>
            @endif
            <span class="text-zinc-900 dark:text-white">{{ $tshirt->name }}</span>
        </nav>
    </div>

    {{-- PRODUCT --}}
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            {{-- IMAGE --}}
            <div class="rounded-2xl overflow-hidden bg-zinc-100 dark:bg-zinc-800" style="aspect-ratio: 1/1;">
                <img
                    src="{{ $tshirt->image_url }}"
                    alt="{{ $tshirt->name }}"
                    class="w-full h-full object-cover"
                />
            </div>

            {{-- DETAILS + FORM --}}
            <div class="flex flex-col gap-6">

                @if($tshirt->category)
                    <a href="{{ route('categories.show', $tshirt->category) }}"
                        class="self-start bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 text-xs font-medium px-3 py-1 rounded-full hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                        {{ $tshirt->category }}
                    </a>
                @endif

                <h1 class="text-3xl md:text-4xl font-black text-zinc-900 dark:text-white leading-tight">
                    {{ $tshirt->name }}
                </h1>

                <p class="text-3xl font-bold text-amber-500 dark:text-amber-400">
                    €{{ number_format($tshirt->price, 2) }}
                </p>

                @if($tshirt->description)
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        {{ $tshirt->description }}
                    </p>
                @endif

                {{-- ADD TO CART FORM --}}
                <form action="{{ route('shop.cart.add', $tshirt) }}" method="POST" class="flex flex-col gap-5">
                    @csrf

                    {{-- COLOR --}}
                    @if($tshirt->colors->count())
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">Colour</label>
                            <div class="flex flex-wrap gap-3" x-data="{ selectedColor: null }">
                                @foreach($tshirt->colors as $color)
                                    <label class="cursor-pointer">
                                        <input
                                            type="radio"
                                            name="color_id"
                                            value="{{ $color->id }}"
                                            class="sr-only peer"
                                            x-on:change="selectedColor = {{ $color->id }}"
                                        />
                                        <span
                                            class="flex items-center justify-center w-8 h-8 rounded-full ring-2 ring-transparent peer-checked:ring-amber-500 peer-checked:ring-offset-2 dark:peer-checked:ring-offset-zinc-900 transition-all"
                                            style="background-color: {{ $color->code }}"
                                            title="{{ $color->name }}"
                                        ></span>
                                    </label>
                                @endforeach
                            </div>
                            @error('color_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    {{-- SIZE --}}
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">Size</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($sizes as $size)
                                <label class="cursor-pointer">
                                    <input type="radio" name="size" value="{{ $size }}" class="sr-only peer" required />
                                    <span class="flex items-center justify-center w-12 h-10 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 text-sm font-semibold text-zinc-700 dark:text-zinc-300 peer-checked:border-amber-500 peer-checked:text-amber-600 dark:peer-checked:text-amber-400 hover:border-zinc-400 transition-colors">
                                        {{ $size }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('size')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- QUANTITY --}}
                    <div>
                        <label for="quantity" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">Quantity</label>
                        <div class="flex items-center gap-3">
                            <flux:input
                                id="quantity"
                                name="quantity"
                                type="number"
                                min="1"
                                max="10"
                                value="{{ old('quantity', 1) }}"
                                class="w-20"
                            />
                        </div>
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SUBMIT --}}
                    <flux:button type="submit" variant="primary" class="w-full py-4 text-base font-bold">
                        Add to Cart
                    </flux:button>

                    @if(session('alert-msg'))
                        <div class="mt-2">
                            <flux:callout variant="{{ session('alert-type', 'info') }}">
                                <div>{!! session('alert-msg') !!}</div>
                            </flux:callout>
                        </div>
                    @endif
                </form>

                {{-- COLORS PREVIEW (bottom) --}}
                @if($tshirt->colors->count())
                    <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-2 uppercase tracking-wide font-semibold">Available Colours</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tshirt->colors as $color)
                                <span
                                    class="w-5 h-5 rounded-full ring-1 ring-zinc-200 dark:ring-zinc-600"
                                    style="background-color: {{ $color->code }}"
                                    title="{{ $color->name }}"
                                ></span>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>

</x-layouts::app.header>
