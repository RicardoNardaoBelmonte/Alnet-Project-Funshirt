<div class="w-full max-w-5xl mx-auto px-8 py-12">
    <div class="flex items-start gap-10">

        <aside class="shrink-0 w-44">
            <div class="sticky top-6">
                <flux:navlist>
                    <flux:navlist.item :href="route('profile.edit')" wire:navigate>
                        Profile
                    </flux:navlist.item>

                    @cannot('admin')
                    <flux:navlist.item :href="route('address.edit')" wire:navigate>
                        Address & Billing
                    </flux:navlist.item>
                    @endcannot

                    <flux:navlist.item :href="route('security.edit')" wire:navigate>
                        Security
                    </flux:navlist.item>

                    <flux:navlist.item :href="route('appearance.edit')" wire:navigate>
                        Appearance
                    </flux:navlist.item>
                </flux:navlist>
            </div>
        </aside>

        <section class="flex-1 min-w-0">

            <div class="mb-8">
                <h1 class="text-2xl font-semibold">{{ $heading }}</h1>
                <p class="mt-2 text-zinc-500 dark:text-zinc-400">{{ $subheading }}</p>
            </div>

            <flux:separator class="mb-8" />

            {{ $slot }}

        </section>

    </div>
</div>
