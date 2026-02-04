{{-- Related Translations Section --}}
<section class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-[#121117] dark:text-white">Shu tarjimondan boshqa ishlar</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($relatedTranslations as $relatedTranslation)
            <div class="group bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 transition-all hover:shadow-sm hover:border-primary/30">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-[#121117] dark:text-white text-sm mb-1 truncate">{{ $relatedTranslation['title'] }}</h3>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded">{{ $relatedTranslation['language_from'] }} → {{ $relatedTranslation['language_to'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center text-yellow-500">
                        <span class="material-symbols-outlined text-[16px] star-filled">star</span>
                        <span class="text-xs font-semibold ml-1">{{ $relatedTranslation['rating'] }}</span>
                    </div>
                    <div class="text-sm font-bold text-[#121117] dark:text-white">UZS {{ number_format($relatedTranslation['price'], 2) }}</div>
                </div>

                <form method="POST" action="{{ route('translation.show', $relatedTranslation['id']) }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full mt-3 py-2 text-center text-primary text-xs font-medium hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition border border-dashed border-gray-300 dark:border-gray-600">
                        Ko'rish
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</section>
