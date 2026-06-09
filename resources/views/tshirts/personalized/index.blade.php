<x-layouts::app.header>

<div class="bg-zinc-50 dark:bg-zinc-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-12">

        {{-- HEADER --}}
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-4xl font-black text-zinc-900 dark:text-white">My Personalized T-Shirts</h1>
                <p class="mt-2 text-zinc-500 dark:text-zinc-400">Upload your own design and we'll print it for you.</p>
            </div>
            <a href="{{ route('my.tshirts.create') }}"
                class="bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold py-3 px-6 rounded-full transition-colors text-sm whitespace-nowrap">
                + New Design
            </a>
        </div>

        {{-- ALERTS --}}
        @if(session('alert-msg'))
            <div class="mb-6">
                <flux:callout variant="{{ session('alert-type', 'info') }}">
                    <div>{!! session('alert-msg') !!}</div>
                </flux:callout>
            </div>
        @endif

        @if($tshirts->isEmpty())

            <div class="text-center py-24 bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700">
                <div class="text-6xl mb-4">🎨</div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">No designs yet</h2>
                <p class="text-zinc-500 dark:text-zinc-400 mb-8">Upload your first personalized t-shirt design!</p>
                <a href="{{ route('my.tshirts.create') }}"
                    class="inline-block bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold py-3 px-8 rounded-full transition-colors">
                    Upload Design
                </a>
            </div>

        @else

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($tshirts as $tshirt)
                    <article class="group bg-white dark:bg-zinc-800 rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">

                        <figure class="overflow-hidden relative" style="aspect-ratio: 1/1;">
                            <img
                                src="{{ route('my.tshirts.image', $tshirt) }}"
                                alt="{{ $tshirt->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            />
                            <div class="absolute top-2 right-2">
                                <span class="bg-amber-400 text-zinc-900 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">
                                    Personalized
                                </span>
                            </div>
                        </figure>

                        <div class="p-4 flex flex-col gap-3">
                            <div>
                                <h3 class="font-semibold text-sm text-zinc-900 dark:text-white leading-tight">{{ $tshirt->name }}</h3>
                                @if($tshirt->description)
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-2">{{ $tshirt->description }}</p>
                                @endif
                            </div>

                            <footer class="flex items-center justify-between pt-1">
                                <strong class="text-amber-500 dark:text-amber-400 font-bold text-sm">€{{ number_format($price->unit_price_own, 2) }}</strong>
                                <a href="{{ route('my.tshirts.show', $tshirt) }}"
                                    class="text-xs text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 transition-colors font-medium">
                                    View →
                                </a>
                            </footer>
                        </div>

                    </article>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            @if($tshirts->hasPages())
                <div class="mt-10">
                    {{ $tshirts->links() }}
                </div>
            @endif

        @endif

    </div>
</div>

</x-layouts::app.header>
