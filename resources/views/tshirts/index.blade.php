<x-layouts::app.header>

<div class="bg-zinc-50 dark:bg-zinc-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-16">

        {{-- HEADER --}}
        <header class="mb-12">
            <p class="text-amber-400 text-sm font-bold tracking-[0.3em] uppercase mb-4">Catalogue</p>
            <h1 class="text-5xl md:text-6xl font-black text-zinc-900 dark:text-white leading-tight">All T-Shirts</h1>
        </header>

        {{-- SEARCH + FILTER --}}
        <form method="GET" action="{{ route('tshirts.index') }}" class="mb-10">
            <div class="flex flex-col sm:flex-row gap-3">

                <div class="relative flex-1">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name or description…"
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm"
                    />
                </div>

                <select
                    name="category"
                    class="sm:w-52 px-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm"
                >
                    <option value="">All categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="px-6 py-3 bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold rounded-xl text-sm transition-colors whitespace-nowrap"
                >
                    Search
                </button>

                @if(request('search') || request('category'))
                    <a
                        href="{{ route('tshirts.index') }}"
                        class="px-6 py-3 border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 font-semibold rounded-xl text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors whitespace-nowrap"
                    >
                        Clear
                    </a>
                @endif

            </div>
        </form>

        {{-- RESULTS COUNT --}}
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-8">
            {{ $tshirts->total() }} {{ Str::plural('design', $tshirts->total()) }} found
            @if(request('search'))
                for <span class="font-semibold text-zinc-700 dark:text-zinc-300">"{{ request('search') }}"</span>
            @endif
            @if(request('category'))
                in <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $categories->firstWhere('id', request('category'))?->name }}</span>
            @endif
        </p>

        {{-- GRID --}}
        @if($tshirts->isEmpty())
            <div class="text-center py-24 bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700">
                <div class="text-5xl mb-4">🔍</div>
                <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">No results found</h2>
                <p class="text-zinc-500 dark:text-zinc-400 mb-6">Try a different search term or category.</p>
                <a href="{{ route('tshirts.index') }}" class="text-amber-500 hover:text-amber-600 font-semibold text-sm">
                    Clear filters →
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($tshirts as $tshirt)
                    @include('partials.tshirt-card', ['tshirt' => $tshirt])
                @endforeach
            </div>

            {{-- PAGINATION --}}
            @if($tshirts->hasPages())
                <div class="mt-12">
                    {{ $tshirts->links() }}
                </div>
            @endif
        @endif

    </div>
</div>

</x-layouts::app.header>
