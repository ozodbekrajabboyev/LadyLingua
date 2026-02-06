<div>
    {{-- Hero Section with Live Search --}}
    <section class="w-full max-w-[1200px] px-4 sm:px-6 lg:px-40 pt-12 sm:pt-16 pb-6 sm:pb-8">
        <div class="max-w-2xl">
            <h2 class="text-[#121117] dark:text-white text-3xl sm:text-4xl lg:text-5xl font-black leading-tight tracking-tight mb-4">
                Professional <span class="text-primary">tarjimonlar</span> bilan bog'laning.
            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-base sm:text-lg leading-relaxed">
                Minimalistik tarjima bozori va jamoat markazi. Mutaxassislarni toping, portfoliolarni ko'rib chiqing va keyingi hamkoringizni yollang.
            </p>
        </div>
    </section>

    {{-- Live Search Section --}}
    <section class="w-full max-w-[1200px] px-4 sm:px-6 lg:px-40 py-4 sm:py-6">
        <div class="relative group">
            <div class="absolute inset-y-0 left-3 sm:left-4 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors text-xl sm:text-2xl">search</span>
            </div>

            <input
                wire:model.live.debounce.300ms="searchQuery"
                class="w-full h-12 sm:h-14 lg:h-16 pl-11 sm:pl-14 pr-24 sm:pr-32 rounded-xl sm:rounded-2xl bg-white dark:bg-gray-900 border-none focus:ring-2 focus:ring-primary/20 text-sm sm:text-base lg:text-lg placeholder:text-gray-400 transition-all shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] dark:shadow-[0_4px_20px_-4px_rgba(255,255,255,0.05)]"
                placeholder="Til, mutaxassislik yoki tarjimon ismi bo'yicha qidiring"
                type="text">

            <div class="absolute inset-y-1 sm:inset-y-2 right-1 sm:right-2 flex items-center">
                @if($searchQuery && $showResults)
                    <button
                        wire:click="clearSearch"
                        class="mr-1 sm:mr-2 p-1.5 sm:p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined text-lg sm:text-xl">close</span>
                    </button>
                @endif

                <button class="h-full px-4 sm:px-6 lg:px-8 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg sm:rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center text-sm sm:text-base">
                    <span wire:loading wire:target="updatedSearchQuery" class="material-symbols-outlined animate-spin mr-1 sm:mr-2 text-sm sm:text-base">sync</span>
                    <span class="hidden sm:inline" wire:loading.remove wire:target="updatedSearchQuery">Qidirish</span>
                    <span class="sm:hidden" wire:loading.remove wire:target="updatedSearchQuery">
                        <span class="material-symbols-outlined text-lg">search</span>
                    </span>
                    <span class="hidden sm:inline" wire:loading wire:target="updatedSearchQuery">Qidirilmoqda...</span>
                    <span class="sm:hidden" wire:loading wire:target="updatedSearchQuery">
                        <span class="material-symbols-outlined animate-spin text-lg">sync</span>
                    </span>
                </button>
            </div>
        </div>

        {{-- Search Results Section --}}
        @if($showResults)
            <div class="mt-4 sm:mt-6 lg:mt-8 bg-white dark:bg-gray-900 rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800">
                {{-- Search Results Header --}}
                <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                            @if($searchResults->count() > 0)
                                {{ $searchResults->count() }} ta natija topildi
                            @else
                                Natija topilmadi
                            @endif
                        </h3>
                        @if($searchQuery)
                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                "{{ Str::limit($searchQuery, 20) }}" uchun qidiruv natijalari
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Search Results Content --}}
                <div class="p-4 sm:p-6">
                    @if($searchResults->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                            @foreach($searchResults as $translation)
                                <x-translation-card
                                    :title="$translation['title']"
                                    :description="$translation['description']"
                                    :language-from="$translation['language_from']"
                                    :language-to="$translation['language_to']"
                                    :rating="$translation['rating']"
                                    :translator-name="$translation['translator_name']"
                                    :translator-image="$translation['translator_image']"
                                    :time-ago="$translation['time_ago']"
                                    :price="$translation['price'] ?? null"
                                    :translation-id="$translation['id'] ?? null"
                                />
                            @endforeach
                        </div>

                        {{-- View All Results Button --}}
                        <div class="flex justify-center mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                            <a href="/translations?search={{ urlencode($searchQuery) }}"
                               class="inline-flex items-center gap-2 text-primary font-semibold hover:underline transition-all duration-200 hover:gap-3">
                                <span>Barcha natijalarni ko'rish</span>
                                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </a>
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-8 sm:py-12">
                            <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 mx-auto mb-4">
                                <span class="material-symbols-outlined text-3xl sm:text-4xl">search_off</span>
                            </div>
                            <h4 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Hech qanday natija topilmadi
                            </h4>
                            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mb-4">
                                "{{ Str::limit($searchQuery, 30) }}" uchun hech qanday tarjima topilmadi
                            </p>
                            <div class="text-xs sm:text-sm text-gray-400 dark:text-gray-500 max-w-md mx-auto">
                                <p class="mb-3 font-medium">Qidiruv takliflari:</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-left">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-primary">check_circle</span>
                                        <span>Boshqa kalit so'zlarni sinab ko'ring</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-primary">check_circle</span>
                                        <span>Imlo xatolari mavjud emasligini tekshiring</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-primary">check_circle</span>
                                        <span>Til nomlarini to'liq yozing</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-primary">check_circle</span>
                                        <span>Tarjimon yoki asar nomini aniq yozing</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Suggested Actions --}}
                            <div class="flex flex-col sm:flex-row gap-3 justify-center items-center mt-6">
                                <a href="/translations"
                                   class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg font-semibold hover:bg-primary/90 transition-all duration-200 text-sm">
                                    <span class="material-symbols-outlined text-lg">explore</span>
                                    <span>Barcha tarjimalarni ko'rish</span>
                                </a>
                                <a href="/translators"
                                   class="inline-flex items-center gap-2 text-primary border border-primary px-4 py-2 rounded-lg font-semibold hover:bg-primary/5 transition-all duration-200 text-sm">
                                    <span class="material-symbols-outlined text-lg">group</span>
                                    <span>Tarjimonlarni ko'rish</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </section>
</div>
