<x-layouts::app.header>

<div class="bg-zinc-50 dark:bg-zinc-900 min-h-screen">
    <div class="max-w-5xl mx-auto px-6 py-12">

        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400 mb-8">
            <a href="{{ route('my.tshirts.index') }}" class="hover:text-zinc-900 dark:hover:text-white transition-colors">My Designs</a>
            <span>→</span>
            <span class="text-zinc-900 dark:text-white">{{ $tshirt->name }}</span>
        </nav>

        {{-- ALERTS --}}
        @if(session('alert-msg'))
            <div class="mb-6">
                <flux:callout variant="{{ session('alert-type', 'info') }}">
                    <div>{!! session('alert-msg') !!}</div>
                </flux:callout>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">

            {{-- PRIVATE IMAGE --}}
            <div class="rounded-2xl overflow-hidden bg-zinc-200 dark:bg-zinc-700 shadow-lg" style="aspect-ratio: 1/1;">
                <img
                    src="{{ route('my.tshirts.image', $tshirt) }}"
                    alt="{{ $tshirt->name }}"
                    class="w-full h-full object-cover"
                />
            </div>

            {{-- DETAILS --}}
            <div class="flex flex-col gap-6">

                <div>
                    <span class="inline-block bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide mb-3">
                        Personalized Design
                    </span>
                    <h1 class="text-3xl font-black text-zinc-900 dark:text-white">{{ $tshirt->name }}</h1>
                    @if($tshirt->description)
                        <p class="mt-3 text-zinc-600 dark:text-zinc-400 leading-relaxed">{{ $tshirt->description }}</p>
                    @endif
                </div>

                <div class="text-3xl font-black text-amber-500 dark:text-amber-400">
                    €{{ number_format($tshirt->price, 2) }}
                    <span class="text-sm font-normal text-zinc-500 dark:text-zinc-400 ml-1">per unit</span>
                </div>

                {{-- ADD TO CART --}}
                <form action="{{ route('shop.cart.add', $tshirt) }}" method="POST" class="flex flex-col gap-4">
                    @csrf

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
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">Quantity</label>
                        <flux:input id="quantity" name="quantity" type="number" min="1" max="10" value="1" class="w-24" />
                    </div>

                    <flux:button type="submit" variant="primary" class="w-full py-4 text-base font-bold">
                        Add to Cart
                    </flux:button>
                </form>

                {{-- MANAGE ACTIONS --}}
                <div class="flex gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <a href="{{ route('my.tshirts.edit', $tshirt) }}"
                        class="flex-1 text-center py-2 rounded-lg border border-zinc-200 dark:border-zinc-600 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                        Edit
                    </a>

                    <form action="{{ route('my.tshirts.destroy', $tshirt) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full py-2 rounded-lg border border-red-200 dark:border-red-900/50 text-sm font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                            onclick="return confirm('Delete this design? This cannot be undone.')">
                            Delete
                        </button>
                    </form>
                </div>

                <p class="text-xs text-zinc-400 dark:text-zinc-500">
                    🔒 This design is private — only you can see it.
                </p>

            </div>

        </div>

    </div>
</div>

</x-layouts::app.header>
