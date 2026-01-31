<div>
    {{-- Hero Section with Live Search --}}
    <section class="w-full max-w-[1200px] px-6 lg:px-40 pt-16 pb-8">
        <div class="max-w-2xl">
            <h2 class="text-[#121117] dark:text-white text-5xl font-black leading-tight tracking-tight mb-4">
                Professional <span class="text-primary">tarjimonlar</span> bilan bog'laning.
            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-lg leading-relaxed">
                Minimalistik tarjima bozori va jamoat markazi. Mutaxassislarni toping, portfoliolarni ko'rib chiqing va keyingi hamkoringizni yollang.
            </p>
        </div>
    </section>

    {{-- Live Search Section --}}
    <section class="w-full max-w-[1200px] px-6 lg:px-40 py-6">
        <div class="relative group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors">search</span>
            </div>

            <input
                wire:model.live.debounce.300ms="searchQuery"
                class="w-full h-16 pl-14 pr-32 rounded-2xl bg-white dark:bg-gray-900 border-none focus:ring-2 focus:ring-primary/20 text-lg placeholder:text-gray-400 transition-all shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]"
                placeholder="Til, mutaxassislik yoki tarjimon ismi bo'yicha qidiring"
                type="text">

            <div class="absolute inset-y-2 right-2 flex items-center">
                @if($searchQuery && $showResults)
                    <button
                        wire:click="clearSearch"
                        class="mr-2 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <span class="material-symbols-outlined text-xl">close</span>
                    </button>
                @endif

                <div class="h-full px-8 bg-primary hover:bg-primary/90 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center">
                    <span wire:loading wire:target="updatedSearchQuery" class="material-symbols-outlined animate-spin mr-2">sync</span>
                    <span wire:loading.remove wire:target="updatedSearchQuery">Qidirish</span>
                    <span wire:loading wire:target="updatedSearchQuery">Qidirilmoqda...</span>
                </div>
            </div>
        </div>

        {{-- Search Results Section --}}
        @if($showResults)
            <div class="mt-8 bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800">
                {{-- Search Results Header --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            @if($searchResults->count() > 0)
                                {{ $searchResults->count() }} ta natija topildi
                            @else
                                Natija topilmadi
                            @endif
                        </h3>
                        @if($searchQuery)
                            <span class="text-sm text-gray-500">
                                "{{ $searchQuery }}" uchun qidiruv natijalari
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Search Results Content --}}
                <div class="p-6">
                    @if($searchResults->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-12">
                            <div class="h-16 w-16 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 mx-auto mb-4">
                                <span class="material-symbols-outlined text-4xl">search_off</span>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Hech qanday natija topilmadi
                            </h4>
                            <p class="text-gray-500 mb-4">
                                "{{ $searchQuery }}" uchun hech qanday tarjima topilmadi
                            </p>
                            <div class="text-sm text-gray-400">
                                <p class="mb-2">Qidiruv takliflari:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Boshqa kalit so'zlarni sinab ko'ring</li>
                                    <li>Imlo xatolari mavjud emasligini tekshiring</li>
                                    <li>Til nomlarini to'liq yozing (masalan: "English", "Russian")</li>
                                    <li>Tarjimon ismi yoki asar nomini aniq yozing</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </section>
</div>
