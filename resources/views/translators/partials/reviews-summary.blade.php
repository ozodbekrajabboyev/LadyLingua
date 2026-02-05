{{-- Reviews Summary Component - Database Data Only --}}
<div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl p-6">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-primary">star</span>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sharhlar</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $translator['reviews'] }} ta sharh</p>
        </div>
    </div>

    <!-- Overall Rating - Real Database Data -->
    <div class="bg-gradient-to-r from-primary/10 to-purple-600/10 rounded-xl p-6 text-center">
        <div class="text-4xl font-bold text-primary mb-3">{{ $translator['rating'] }}</div>
        <div class="flex items-center justify-center mb-2">
            @for($i = 1; $i <= 5; $i++)
                <span class="material-symbols-outlined text-yellow-400 {{ $i <= floor($translator['rating']) ? 'star-filled' : '' }}">
                    {{ $i <= floor($translator['rating']) ? 'star' : ($i <= ceil($translator['rating']) ? 'star_half' : 'star_border') }}
                </span>
            @endfor
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $translator['reviews'] }} ta sharhga asosan</p>
    </div>

    @if($translator['reviews'] == 0)
        <!-- No Reviews State -->
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-gray-400 text-2xl">star_border</span>
            </div>
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Hozircha sharhlar yo'q</h4>
            <p class="text-gray-500 dark:text-gray-400">
                Bu tarjimon uchun hali sharhlar mavjud emas.
            </p>
        </div>
    @endif
</div>
