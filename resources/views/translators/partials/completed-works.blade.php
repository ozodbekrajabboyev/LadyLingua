{{-- Completed Works Section --}}
<section class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-[#121117] dark:text-white">So'nggi ishlar</h2>
        @if(count($translations) > 0)
            <button class="text-primary text-sm font-medium hover:underline">
                Barchasini ko'rish
            </button>
        @endif
    </div>

    @if(count($translations) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($translations as $translation)
                <div class="group bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 transition-all hover:shadow-sm hover:border-primary/30">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-[#121117] dark:text-white text-sm mb-1 truncate">{{ $translation['title'] }}</h3>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded">{{ $translation['language_from'] }} → {{ $translation['language_to'] }}</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">
                        {{ $translation['description'] }}
                    </p>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-yellow-500">
                            <span class="material-symbols-outlined text-[16px] star-filled">star</span>
                            <span class="text-xs font-semibold ml-1">{{ $translation['rating'] }}</span>
                        </div>
                        <span class="text-xs text-gray-500">{{ $translation['time'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <div class="bg-gray-100 dark:bg-gray-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-gray-400 text-2xl">assignment</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Hozircha tarjimalar yo'q</h3>
            <p class="text-gray-500">Bu tarjimon hali hech qanday tarjimani nashr qilmagan.</p>
        </div>
    @endif
</section>
