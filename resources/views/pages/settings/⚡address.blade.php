<?php

use App\Models\Customer;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Address & Billing')] class extends Component {
    public string $nif = '';
    public string $address = '';
    public string $default_payment_type = '';
    public string $default_payment_ref = '';

    public function mount(): void
    {
        abort_if(Auth::user()->admin, 403);

        $customer = Auth::user()->customer;

        if ($customer) {
            $this->nif                  = $customer->nif ?? '';
            $this->address              = $customer->address ?? '';
            $this->default_payment_type = $customer->default_payment_type ?? '';
            $this->default_payment_ref  = $customer->default_payment_ref ?? '';
        }
    }

    public function updatedDefaultPaymentType(string $value): void
    {
        $this->default_payment_ref = $value === 'paypal' ? Auth::user()->email : '';
    }

    public function save(): void
    {
        abort_if(Auth::user()->admin, 403);

        $refRules = match ($this->default_payment_type) {
            'visa'   => ['nullable', 'regex:/^4[0-9]{15}$/'],
            'mbway'  => ['nullable', 'regex:/^9[0-9]{8}$/'],
            'paypal' => ['nullable', 'email', 'max:255'],
            default  => ['nullable', 'string', 'max:100'],
        };

        $validated = $this->validate([
            'nif'                  => ['nullable', 'string', 'max:20'],
            'address'              => ['nullable', 'string', 'max:500'],
            'default_payment_type' => ['nullable', 'in:visa,paypal,mbway'],
            'default_payment_ref'  => $refRules,
        ]);

        Customer::updateOrCreate(
            ['id' => Auth::id()],
            $validated
        );

        Flux::toast(variant: 'success', text: __('Address & billing updated.'));
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Address & Billing') }}</flux:heading>

    <x-pages::settings.layout
        :heading="__('Address & Billing')"
        :subheading="__('Save your details once and they will pre-fill at checkout')"
    >
        <form wire:submit="save" class="my-6 w-full space-y-6">

            <flux:input
                wire:model="nif"
                :label="__('NIF (Tax Number)')"
                type="text"
                maxlength="20"
                placeholder="000000000"
                autocomplete="off"
            />

            <flux:textarea
                wire:model="address"
                :label="__('Delivery Address')"
                rows="3"
                :placeholder="__('Street and number, city, postal code')"
            />

            <flux:select wire:model.live="default_payment_type" :label="__('Default Payment Method')">
                <option value="">{{ __('— Select method —') }}</option>
                <option value="visa">Visa</option>
                <option value="paypal">PayPal</option>
                <option value="mbway">MB WAY</option>
            </flux:select>

            @if ($default_payment_type)
                @php
                    [$refType, $refPlaceholder, $refHint, $refMaxlength] = match ($default_payment_type) {
                        'visa'   => ['text',  '4321567812345678',       __('16 digits starting with 4'),   16],
                        'paypal' => ['email', auth()->user()->email,     __('Your PayPal email address'),   255],
                        'mbway'  => ['text',  '915785345',               __('9 digits starting with 9'),    9],
                        default  => ['text',  '',                         '',                               100],
                    };
                @endphp

                <div>
                    <flux:input
                        wire:model="default_payment_ref"
                        :label="__('Payment Reference')"
                        :type="$refType"
                        :placeholder="$refPlaceholder"
                        :maxlength="$refMaxlength"
                        autocomplete="off"
                    />
                    @if ($refHint)
                        <flux:text class="mt-1.5 text-xs text-zinc-500 dark:text-zinc-400">
                            {{ $refHint }}
                        </flux:text>
                    @endif
                    <flux:error name="default_payment_ref" />
                </div>
            @endif

            <div class="rounded-lg bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 p-4 text-sm text-amber-800 dark:text-amber-300">
                {{ __('This information will pre-fill your checkout. You can always update it during payment.') }}
            </div>

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
            </div>

        </form>
    </x-pages::settings.layout>
</section>
