<x-layouts::app.header>

<div class="bg-zinc-50 dark:bg-zinc-900 min-h-screen">

    <div class="max-w-7xl mx-auto px-6 py-20">

        <header class="mb-16">
            <p class="text-amber-400 text-sm font-bold tracking-[0.3em] uppercase mb-5">Browse</p>
            <h1 class="text-5xl md:text-6xl font-black text-zinc-900 dark:text-white leading-tight">All Categories</h1>
        </header>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($categories as $category)
            <a
                href="{{ route('categories.show', $category) }}"
                class="group relative rounded-2xl overflow-hidden"
                style="aspect-ratio: 3/4;"
            >
                <img
                    src="{{ $category->image_url }}"
                    alt="{{ $category->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/90 via-zinc-950/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h2 class="text-white font-bold text-base leading-tight">{{ $category->name }}</h2>
                    <span class="text-amber-400 text-xs mt-1 inline-block">{{ $category->tshirts_count }} designs</span>
                </div>
            </a>
            @endforeach
        </div>

    </div>

</div>

</x-layouts::app.header>
