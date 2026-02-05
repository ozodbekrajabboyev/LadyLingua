{{-- Cleaned Completed Works Section - Only Database Data --}}
<section class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl p-6">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-primary">work</span>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Bajarilgan ishlar</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                @if(count($translations) > 0)
                    {{ count($translations) }} ta tarjima
                @else
                    Hozircha tarjimalar yo'q
                @endif
            </p>
        </div>
    </div>

    @if(count($translations) > 0)
        <!-- Works Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($translations as $translation)
                <div class="group bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl p-5 transition-all duration-300 hover:shadow-lg hover:border-primary/30">
                    <!-- Work Header -->
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white text-base mb-2 line-clamp-2">
                            {{ $translation['title'] }}
                        </h3>

                        <!-- Language Pair - Real Database Data -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 px-2 py-1 rounded-full">
                                {{ $translation['language_from'] }}
                            </span>
                            <span class="material-symbols-outlined text-gray-400 text-sm">arrow_forward</span>
                            <span class="text-xs bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 px-2 py-1 rounded-full">
                                {{ $translation['language_to'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Work Description - Real Database Data -->
                    @if(!empty($translation['description']))
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-4 leading-relaxed">
                            {{ $translation['description'] }}
                        </p>
                    @endif

                    <!-- Work Stats - Real Database Data Only -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600">
                        <!-- Rating - Real Database Data -->
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="material-symbols-outlined text-yellow-400 text-sm {{ $i <= floor($translation['rating']) ? 'star-filled' : '' }}">
                                    {{ $i <= floor($translation['rating']) ? 'star' : 'star_border' }}
                                </span>
                            @endfor
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">{{ $translation['rating'] }}</span>
                        </div>

                        <!-- Last Updated - Real Database Data -->
                        <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            <span>{{ $translation['time'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Show More Button -->
        @if(count($translations) >= 6)
            <div class="text-center mt-6">
                <button class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200">
                    <span>Ko'proq ko'rish</span>
                    <span class="material-symbols-outlined">expand_more</span>
                </button>
            </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-gray-400 text-2xl">work_outline</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Hozircha tarjimalar yo'q</h3>
            <p class="text-gray-500 dark:text-gray-400">
                Bu tarjimon hali hech qanday tarjimani nashr qilmagan.
            </p>
        </div>
    @endif
</section>
