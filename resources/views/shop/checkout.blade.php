<x-layouts::app.header>

<div class="bg-zinc-50 dark:bg-zinc-900 min-h-screen">
    <div class="max-w-4xl mx-auto px-6 py-12">

        {{-- HEADER --}}
        <div class="mb-8">
            <a href="{{ route('shop.cart.show') }}" class="text-sm text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                ← Back to Cart
            </a>
            <h1 class="mt-4 text-4xl font-black text-zinc-900 dark:text-white">Checkout</h1>
        </div>

        {{-- ALERTS --}}
        @if($errors->any())
            <div class="mb-6">
                <flux:callout variant="error">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </flux:callout>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- CHECKOUT FORM --}}
            <div class="lg:col-span-2">

                {{-- CUSTOMER INFORMATION --}}
                <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Customer Information</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Name</label>
                            <p class="text-zinc-900 dark:text-white">{{ auth()->user()->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Email</label>
                            <p class="text-zinc-900 dark:text-white">{{ auth()->user()->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">NIF (Tax ID)</label>
                            <p class="text-zinc-900 dark:text-white">{{ $customer->nif ?? 'Not provided' }}</p>
                        </div>

                        <div>
                            <a href="{{ route('profile.edit') }}"
                                class="text-sm text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors">
                                Edit Customer Information
                            </a>
                        </div>
                    </div>
                </div>

                {{-- SHIPPING ADDRESS --}}
                <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Shipping Address</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Address</label>
                            <p class="text-zinc-900 dark:text-white whitespace-pre-wrap">{{ $customer->address }}</p>
                        </div>

                        <div>
                            <a href="{{ route('address.edit') }}"
                                class="text-sm text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors">
                                Change Shipping Address
                            </a>
                        </div>
                    </div>
                </div>

                {{-- PAYMENT METHOD --}}
                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Payment Method</h2>

                        <div class="space-y-3">
                            <label class="flex items-center p-3 border border-zinc-200 dark:border-zinc-600 rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors"
                                :class="{ 'border-amber-400 bg-amber-50 dark:bg-amber-900/20': $wire.payment_type === 'Visa' }">
                                <input type="radio" name="payment_type" value="Visa" required
                                    class="w-4 h-4 text-amber-400 focus:ring-amber-500"
                                    @if(old('payment_type') === 'Visa' || !old('payment_type')) checked @endif />
                                <div class="ml-3">
                                    <p class="font-medium text-zinc-900 dark:text-white">Visa</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Pay securely with your card</p>
                                </div>
                            </label>

                            <label class="flex items-center p-3 border border-zinc-200 dark:border-zinc-600 rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors"
                                :class="{ 'border-amber-400 bg-amber-50 dark:bg-amber-900/20': $wire.payment_type === 'PayPal' }">
                                <input type="radio" name="payment_type" value="PayPal" required
                                    class="w-4 h-4 text-amber-400 focus:ring-amber-500"
                                    @if(old('payment_type') === 'PayPal') checked @endif />
                                <div class="ml-3">
                                    <p class="font-medium text-zinc-900 dark:text-white">PayPal</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Direct bank transfer</p>
                                </div>
                            </label>

                            <label class="flex items-center p-3 border border-zinc-200 dark:border-zinc-600 rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors"
                                :class="{ 'border-amber-400 bg-amber-50 dark:bg-amber-900/20': $wire.payment_type === 'MB WAY' }">
                                <input type="radio" name="payment_type" value="MB WAY" required
                                    class="w-4 h-4 text-amber-400 focus:ring-amber-500"
                                    @if(old('payment_type') === 'MB WAY') checked @endif />
                                    <div class="ml-3">
                                        <p class="font-medium text-zinc-900 dark:text-white">MB WAY</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Pay via MB WAY mobile payment</p>
                                </div>
                            </label>
                        </div>

                        @error('payment_type')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6" x-show="payment_type === 'MB WAY'">
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Bank Transfer Reference</h2>
                            <div>
                                <label for="payment_ref" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Reference/Note (optional)
                                </label>
                                <textarea name="payment_ref" id="payment_ref" rows="2"
                                    class="w-full px-3 py-2 border border-zinc-200 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-400"
                                    placeholder="e.g., Invoice number or reference">{{ old('payment_ref') }}</textarea>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    This will help us match your payment to this order
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- ORDER NOTES --}}
                    <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Order Notes</h2>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Special Instructions (optional)
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                class="w-full px-3 py-2 border border-zinc-200 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-400"
                                placeholder="Add any special requests or instructions for your order...">{{ old('notes') }}</textarea>
                        </div>

                        @error('notes')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <div class="flex gap-4">
                        <a href="{{ route('shop.cart.show') }}"
                            class="flex-1 text-center px-6 py-4 border border-zinc-200 dark:border-zinc-600 text-zinc-900 dark:text-white font-bold rounded-full hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                            Continue Shopping
                        </a>
                        <button type="submit"
                            class="flex-1 px-6 py-4 bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold rounded-full transition-colors">
                            Complete Order
                        </button>
                    </div>
                </form>

            </div>

            {{-- ORDER SUMMARY SIDEBAR --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6 sticky top-8">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Order Summary</h2>

                    <div class="space-y-3 mb-6 max-h-96 overflow-y-auto">
                        @php
                            $tshirtIds = array_unique(array_column($cart, 'tshirt_image_id'));
                            $tshirts = $tshirtIds
                                ? \App\Models\TshirtImage::whereIn('id', $tshirtIds)->get()->keyBy('id')
                                : collect();
                        @endphp

                        @foreach($cart as $item)
                            @php
                                $tshirt = $tshirts->get($item['tshirt_image_id']);
                            @endphp
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="font-medium text-zinc-900 dark:text-white">
                                        {{ $tshirt?->name ?? 'Product' }}
                                    </p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $item['size'] }} × {{ $item['qty'] }}
                                    </p>
                                </div>
                                <p class="font-medium text-zinc-900 dark:text-white text-right">
                                    €{{ number_format($item['unit_price'] * $item['qty'], 2) }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-zinc-100 dark:border-zinc-700 pt-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-semibold text-zinc-900 dark:text-white">Total</span>
                            <span class="text-2xl font-black text-amber-500 dark:text-amber-400">
                                €{{ number_format($total, 2) }}
                            </span>
                        </div>

                        <p class="text-xs text-zinc-500 dark:text-zinc-400 text-center">
                            Items will be shipped to your registered address
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="payment_type"]');
        const paymentRefDiv = document.querySelector('[x-show]');

        function togglePaymentRef() {
            const checked = document.querySelector('input[name="payment_type"]:checked');
            if (paymentRefDiv) {
                // Show reference field only for MB WAY payments
                if (checked && checked.value === 'MB WAY') {
                    paymentRefDiv.style.display = '';
                } else {
                    paymentRefDiv.style.display = 'none';
                }
            }
        }

        radios.forEach(radio => {
            radio.addEventListener('change', togglePaymentRef);
        });

        // Initialize on page load
        togglePaymentRef();
    });
</script>

</x-layouts::app.header>
