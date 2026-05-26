<article class="group bg-white dark:bg-zinc-900 rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">

    <figure class="overflow-hidden" style="aspect-ratio: 1/1;">
        <img
            src="{{ $tshirt->image_url }}"
            alt="{{ $tshirt->name }}"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
        />
    </figure>

    <div class="p-4 flex flex-col gap-3">

        {{-- Category badge --}}
        @if($tshirt->category)
            <a href="{{ route('categories.show', $tshirt->category) }}" class="inline-block self-start bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 text-xs font-medium px-3 py-1 rounded-full hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                {{ $tshirt->category->name }}
            </a>
        @endif

        {{-- Name + description --}}
        <div class="flex flex-col gap-2">
            <h3 class="text-zinc-900 dark:text-white font-semibold text-sm leading-relaxed">{{ $tshirt->name }}</h3>
            @if($tshirt->description)
                <p class="text-zinc-500 dark:text-zinc-400 text-xs leading-relaxed line-clamp-2">{{ $tshirt->description }}</p>
            @endif
        </div>

        {{-- Colors --}}
        @if($tshirt->colors->count())
            <div class="flex flex-wrap gap-2">
                @foreach($tshirt->colors->take(6) as $color)
                    <span
                        class="w-4 h-4 rounded-full flex-shrink-0 ring-1 ring-zinc-300 dark:ring-zinc-600"
                        style="background-color: {{ $color->code }}"
                        title="{{ $color->name }}"
                    ></span>
                @endforeach
            </div>
        @endif

        {{-- Price + link --}}
        <footer class="flex items-center justify-between pt-1">
            <strong class="text-amber-500 dark:text-amber-400 font-bold text-base">€{{ number_format($tshirt->price, 2) }}</strong>
            @if($tshirt->category)
                <a
                    href="{{ route('categories.show', $tshirt->category) }}"
                    class="text-xs text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 transition-colors"
                >
                    View →
                </a>
            @endif
        </footer>

    </div>

</article>
