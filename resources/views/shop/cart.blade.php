<x-layouts::app.header>

<div class="bg-zinc-50 dark:bg-zinc-900 min-h-screen">
    <div class="max-w-5xl mx-auto px-6 py-12">

        {{-- HEADER --}}
        <div class="mb-8">
            <a href="{{ route('home') }}" class="text-sm text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                ← Continue Shopping
            </a>
            <h1 class="mt-4 text-4xl font-black text-zinc-900 dark:text-white">Shopping Cart</h1>
        </div>

        {{-- ALERTS --}}
        @if(session('alert-msg'))
            <div class="mb-6">
                <flux:callout variant="{{ session('alert-type', 'info') }}">
                    <div>{!! session('alert-msg') !!}</div>
                </flux:callout>
            </div>
        @endif

        @if(empty($cart))

            {{-- EMPTY STATE --}}
            <div class="text-center py-24 bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">Your cart is empty</h2>
                <p class="text-zinc-500 dark:text-zinc-400 mb-8">Looks like you haven't added anything yet.</p>
                <a href="{{ route('home') }}"
                    class="inline-block bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold py-3 px-8 rounded-full transition-colors">
                    Shop Now
                </a>
            </div>

        @else

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- CART ITEMS --}}
                <div class="lg:col-span-2 flex flex-col gap-4">

                    @foreach($cart as $key => $item)
                        @php
                            $tshirt  = $tshirts->get($item['tshirt_image_id']);
                            $color   = $colors->get($item['color_code']);
                            $subtotal = $item['unit_price'] * $item['qty'];
                        @endphp

                        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-4 flex gap-4">

                            {{-- IMAGE --}}
                            <div class="flex-none w-24 h-24 rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-700">
                                @if($tshirt)
                                    @if($tshirt->customer_id !== null)
                                        <img src="{{ route('my.tshirts.image', $tshirt) }}" alt="{{ $tshirt->name }}"
                                            class="w-full h-full object-cover" />
                                    @else
                                        <img src="{{ $tshirt->image_url }}" alt="{{ $tshirt->name }}"
                                            class="w-full h-full object-cover" />
                                    @endif
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-2xl">🎨</div>
                                @endif
                            </div>

                            {{-- INFO --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-zinc-900 dark:text-white text-sm leading-tight truncate">
                                    {{ $tshirt?->name ?? 'Product not found' }}
                                </h3>

                                <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span class="font-medium uppercase tracking-wide">{{ $item['size'] }}</span>
                                    @if($color)
                                        <span class="flex items-center gap-1">
                                            <span class="w-3 h-3 rounded-full ring-1 ring-zinc-300 dark:ring-zinc-600 inline-block" style="background-color: {{ $color->code }}"></span>
                                            {{ $color->name }}
                                        </span>
                                    @endif
                                    @if($tshirt?->customer_id !== null)
                                        <span class="bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                            Personalized
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-2 text-sm font-semibold text-amber-500 dark:text-amber-400">
                                    €{{ number_format($item['unit_price'], 2) }} each
                                </p>

                                {{-- QUANTITY UPDATE --}}
                                <form action="{{ route('shop.cart.update') }}" method="POST" class="mt-3 flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <label class="text-xs text-zinc-500 dark:text-zinc-400">Qty:</label>
                                    <select name="qty" onchange="this.form.submit()"
                                        class="text-sm rounded-lg border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white px-2 py-1 focus:outline-none focus:ring-2 focus:ring-amber-400">
                                        <option value="0">0 (remove)</option>
                                        @for($q = 1; $q <= 99; $q++)
                                            <option value="{{ $q }}" {{ $item['qty'] == $q ? 'selected' : '' }}>{{ $q }}</option>
                                        @endfor
                                    </select>
                                </form>
                            </div>

                            {{-- SUBTOTAL + REMOVE --}}
                            <div class="flex-none flex flex-col items-end justify-between">
                                <p class="font-bold text-zinc-900 dark:text-white text-sm">
                                    €{{ number_format($subtotal, 2) }}
                                </p>

                                <form action="{{ route('shop.cart.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <button type="submit"
                                        class="text-xs text-zinc-400 hover:text-red-500 transition-colors"
                                        onclick="return confirm('Remove this item?')">
                                        Remove
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach

                    {{-- CLEAR CART --}}
                    <div class="flex justify-end">
                        <form action="{{ route('shop.cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm text-zinc-400 hover:text-red-500 transition-colors"
                                onclick="return confirm('Clear the entire cart?')">
                                Clear cart
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ORDER SUMMARY --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6 sticky top-8">
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Order Summary</h2>

                        <div class="flex flex-col gap-3 text-sm">
                            @foreach($cart as $item)
                                <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                                    <span>{{ $tshirts->get($item['tshirt_image_id'])?->name ?? 'Item' }} × {{ $item['qty'] }}</span>
                                    <span>€{{ number_format($item['unit_price'] * $item['qty'], 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-700 flex justify-between items-center">
                            <span class="font-semibold text-zinc-900 dark:text-white">Total</span>
                            <span class="text-2xl font-black text-amber-500 dark:text-amber-400">€{{ number_format($total, 2) }}</span>
                        </div>

                        <div class="mt-6">
                            @auth
                                <a href="{{ route('checkout.show') }}"
                                    class="block w-full text-center bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold py-4 rounded-full transition-colors">
                                    Checkout
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="block w-full text-center bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold py-4 rounded-full transition-colors">
                                    Login to Checkout
                                </a>
                                <p class="mt-2 text-xs text-center text-zinc-500 dark:text-zinc-400">
                                    Your cart is saved. Login to complete your order.
                                </p>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>

        @endif

    </div>
</div>

</x-layouts::app.header>
