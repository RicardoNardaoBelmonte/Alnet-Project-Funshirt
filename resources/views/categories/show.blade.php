<x-layouts::app.header>

<div class="bg-white dark:bg-zinc-900 min-h-screen">

    {{-- CATEGORY HEADER --}}
    <div class="relative h-48 overflow-hidden bg-zinc-200 dark:bg-zinc-800">
        <img
            src="{{ $category->image_url }}"
            alt="{{ $category->name }}"
            class="w-full h-full object-cover opacity-50"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 max-w-7xl mx-auto px-6 pb-6">
            <a href="{{ route('home') }}" class="text-zinc-400 hover:text-white text-sm transition-colors mb-2 inline-block">
                ← Back to Home
            </a>
            <h1 class="text-4xl font-black text-white">{{ $category->name }}</h1>
        </div>
    </div>

    {{-- T-SHIRTS GRID --}}
    <div class="max-w-7xl mx-auto px-6 py-12">

        @if($tshirts->isEmpty())
            <div class="text-center py-20">
                <p class="text-zinc-500 text-lg">No t-shirts available in this category yet.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block text-amber-400 hover:underline">
                    Back to Home
                </a>
            </div>
        @else
            <p class="text-zinc-500 dark:text-zinc-400 mb-8">{{ $tshirts->count() }} {{ Str::plural('design', $tshirts->count()) }} available</p>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($tshirts as $tshirt)
                    @include('partials.tshirt-card', ['tshirt' => $tshirt])
                @endforeach
            </div>
        @endif

    </div>
</div>

</x-layouts::app.header>
