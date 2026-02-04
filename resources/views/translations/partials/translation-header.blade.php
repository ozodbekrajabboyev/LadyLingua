{{-- Translation Header Section --}}
<section class="w-full bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-start gap-4">
            {{-- Book Cover --}}
            <div class="w-16 h-24 rounded bg-gray-200 bg-cover bg-center shadow-sm shrink-0"
                 data-alt="Cover of the book {{ $translation['title'] }}"
                 style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC7p7cIOZm9hUBLfP66m2YzOBmY-W1mr6Jv3m42Uj36h9de7Qz8WzttAkrFku5wp72oXB4oKRRy8iqla1CppRqdQHfTkFxne0RG2xDxoZuMqvKiaGjWe1v8nx3Q5sS_vv9XWJaIr7OhBN6326yDWHrSCrlpxCVTzEVShO2OUtKFoRr2Ybbg_nP7AQkxO_XRweIRu7SS_nv7RD45Js2EWWoc-XeIClWL9rtBDXIBHbX5qBALqalVFLMeYiPucjWS8KNnT4e7XXB_X_Y');">
            </div>

            {{-- Book Info --}}
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#121117] dark:text-white leading-tight mb-1">
                    {{ $translation['title'] }}
                </h1>

                <div class="flex flex-wrap gap-2 text-sm text-gray-500 dark:text-gray-400 items-center">
                    {{-- Author --}}
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">edit</span>
                        Muallif: <span class="font-medium text-gray-900 dark:text-gray-200">{{ $translation['author'] }}</span>
                    </span>

                    <span class="hidden md:inline text-gray-300">|</span>
                    {{-- Translator --}}
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">translate</span>
                        Tarjimon: <a target="_blank" class="font-medium text-primary hover:underline" href="/translator/{{ $translation['translator_id'] }}">{{ $translation['translator_name'] }}</a>
                    </span>

                    <span class="hidden md:inline text-gray-300">|</span>

                    {{-- Language --}}
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">language</span>
                        {{ $translation['language_from'] }} → {{ $translation['language_to'] }}
                    </span>
                </div>

                <div class="flex items-center gap-3 mt-3">
                    {{-- Rating --}}
                    <div class="flex items-center text-yellow-500">
                        <span class="material-symbols-outlined text-lg star-filled">star</span>
                        <span class="font-semibold ml-1">{{ $translation['rating'] }}</span>
                        <span class="text-xs text-gray-500 ml-1">({{ $translation['total_reviews'] }} sharh)</span>
                    </div>

                    {{-- Updated Time --}}
                    <span class="text-xs text-gray-500">{{ $translation['updated_at'] }} yangilangan</span>
                </div>
            </div>
        </div>

        {{-- Purchase Section --}}
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <div class="text-center sm:text-right">
                <div class="text-2xl font-bold text-[#121117] dark:text-white">UZS {{ number_format($translation['price'], 2) }}</div>
                <div class="text-xs text-gray-500">PDF format</div>
            </div>
            <button class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2 min-w-[120px] justify-center">
                <span class="material-symbols-outlined text-lg">shopping_cart</span>
                Sotib olish
            </button>
        </div>
    </div>

    {{-- Description --}}
    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
            {{ $translation['description'] }}
        </p>
    </div>
</section>
