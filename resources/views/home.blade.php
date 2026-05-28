<x-layouts::app.header>

{{-- ═══════════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden" style="min-height: 75vh;">

    {{-- Background image --}}
    <div class="absolute inset-0">
        <img
            src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=1920&h=1080&fit=crop&auto=format&q=80"
            alt=""
            class="w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950/95 via-zinc-950/70 to-zinc-950/20"></div>
        <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-zinc-900 dark:from-zinc-900 to-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 flex items-center h-full max-w-7xl mx-auto px-6 py-28 md:py-36">
        <div class="max-w-2xl">
            <p class="text-amber-400 text-xs font-bold tracking-[0.25em] uppercase mb-5">
                Custom T-Shirts
            </p>
            <h1 class="text-7xl md:text-8xl lg:text-9xl font-black text-white leading-none mb-6 tracking-tight">
                Fun<span class="text-amber-400">Shirt</span>
            </h1>
            <p class="text-lg md:text-xl text-zinc-300 leading-relaxed mb-10 max-w-lg">
                Wear your identity. Unique custom t-shirts for streetwear, anime,
                sports and celebrity culture.
            </p>
            <div class="flex flex-wrap gap-4">
                <a
                    href="#categories"
                    class="bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold py-4 px-10 rounded-full text-base transition-colors"
                >
                    Shop Now
                </a>
                @guest
                    <a
                        href="{{ route('register') }}"
                        class="text-white font-bold py-4 px-10 rounded-full text-base transition-colors"
                    >
                        Create Account
                    </a>
                @endguest
            </div>
        </div>
    </div>

</section>

{{-- ═══════════════════════════════════════════════════════════
     CATEGORIES
═══════════════════════════════════════════════════════════ --}}
<section id="categories" class="bg-zinc-50 dark:bg-zinc-900 py-20">
    <div class="max-w-7xl mx-auto px-6">

        <div
            x-data="{
                atStart: true,
                atEnd: false,
                prev() { $refs.track.scrollBy({ left: -240, behavior: 'smooth' }) },
                next() { $refs.track.scrollBy({ left: 240, behavior: 'smooth' }) },
                update() {
                    const t = $refs.track;
                    this.atStart = t.scrollLeft <= 4;
                    this.atEnd   = t.scrollLeft + t.clientWidth >= t.scrollWidth - 4;
                }
            }"
            x-init="update(); $refs.track.addEventListener('scroll', () => update())"
        >

            {{-- Header row: title + nav arrows --}}
            <div class="flex items-end justify-between mb-10">
                <div>
                    <p class="text-amber-400 text-sm font-bold tracking-[0.3em] uppercase mb-5">Browse</p>
                    <h2 class="text-5xl md:text-6xl font-black text-zinc-900 dark:text-white leading-tight">Shop by Category</h2>
                </div>
                <div class="flex gap-2 mb-1">
                    <button
                        @click="prev()"
                        :disabled="atStart"
                        :class="atStart ? 'opacity-30 cursor-default' : 'hover:bg-amber-400 hover:text-zinc-900 hover:border-amber-400'"
                        class="w-10 h-10 rounded-full border-2 border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 flex items-center justify-center transition-colors"
                        aria-label="Previous categories"
                    >←</button>
                    <button
                        @click="next()"
                        :disabled="atEnd"
                        :class="atEnd ? 'opacity-30 cursor-default' : 'hover:bg-amber-400 hover:text-zinc-900 hover:border-amber-400'"
                        class="w-10 h-10 rounded-full border-2 border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 flex items-center justify-center transition-colors"
                        aria-label="Next categories"
                    >→</button>
                </div>
            </div>

            {{-- Scrollable track --}}
            <div
                x-ref="track"
                class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
            >
                @foreach($categories as $category)
                <a
                    href="{{ $category['url'] }}"
                    class="snap-start flex-none w-44 md:w-52 group relative rounded-2xl overflow-hidden"
                    style="aspect-ratio: 3/4;"
                >
                    <img
                        src="{{ $category['image_url'] }}"
                        alt="{{ $category['name'] }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/90 via-zinc-950/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <h3 class="text-white font-bold text-base leading-tight">{{ $category['name'] }}</h3>
                        <span class="text-amber-400 text-xs mt-1 inline-block">Browse →</span>
                    </div>
                </a>
                @endforeach
            </div>

        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     BEST SELLERS
═══════════════════════════════════════════════════════════ --}}
<section class="bg-white dark:bg-zinc-800 py-20">
    <div class="max-w-7xl mx-auto px-6">

        <header class="mb-16">
            <p class="text-amber-400 text-sm font-bold tracking-[0.3em] uppercase mb-5">Top Picks</p>
            <h2 class="text-5xl md:text-6xl font-black text-zinc-900 dark:text-white leading-tight">Best Sellers</h2>
        </header>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($bestSellers as $tshirt)
                @include('partials.tshirt-card', ['tshirt' => $tshirt])
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     RECENTLY RELEASED
═══════════════════════════════════════════════════════════ --}}
<section class="bg-zinc-50 dark:bg-zinc-900 py-20">
    <div class="max-w-7xl mx-auto px-6">

        <header class="mb-16">
            <p class="text-amber-400 text-sm font-bold tracking-[0.3em] uppercase mb-5">New Arrivals</p>
            <h2 class="text-5xl md:text-6xl font-black text-zinc-900 dark:text-white leading-tight">Recently Released</h2>
        </header>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($recentlyReleased as $tshirt)
                @include('partials.tshirt-card', ['tshirt' => $tshirt])
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     FOOTER CTA
═══════════════════════════════════════════════════════════ --}}
@guest
<section class="bg-zinc-50 dark:bg-zinc-900 py-16">
    <div class="max-w-2xl mx-auto px-6 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white mb-3">Want something unique?</h2>
        <p class="text-zinc-600 dark:text-zinc-400 mb-8 text-base">
            Create your own custom t-shirt design and stand out from the crowd.
        </p>
        <a
            href="{{ route('register') }}"
            class="inline-block bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold py-3 px-10 rounded-full transition-colors"
        >
            Get Started
        </a>
    </div>
</section>
@endguest

</x-layouts::app.header>
