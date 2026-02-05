<div class="group relative bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg hover:border-primary/20 translator-card">
    <!-- Simplified Favorite Button - only shows on hover -->
    <button class="favorite-btn absolute top-4 right-4 w-8 h-8 rounded-full bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm border border-gray-200/50 dark:border-gray-600/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200"
            data-translator-id="{{ $id }}" data-tooltip="Sevimlilarga qo'shish">
        <span class="material-symbols-outlined text-gray-400 hover:text-red-500 text-lg">favorite_border</span>
    </button>

    <div class="flex flex-col sm:flex-row gap-6">
        <!-- Simplified Avatar Section -->
        <div class="flex-shrink-0 relative">
            <div class="size-28 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 overflow-hidden ring-2 ring-gray-200 dark:ring-gray-600 relative transition-all duration-300">
                <img alt="{{ $name }}"
                     class="h-full w-full object-cover transition-transform duration-300"
                     src="{{ $avatar }}"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="absolute inset-0 bg-gradient-to-br from-primary to-purple-600 flex items-center justify-center text-white text-xl font-bold"
                     style="display:none;">
                    {{ strtoupper(substr($name, 0, 2)) }}
                </div>

                <!-- Simple Verification Badge -->
                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white dark:border-gray-900 flex items-center justify-center"
                     data-tooltip="Tasdiqlangan tarjimon">
                    <span class="material-symbols-outlined text-white text-sm">verified</span>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="flex-1 min-w-0">
            <!-- Header with Name -->
            <div class="flex items-start justify-between gap-3 mb-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="text-xl font-bold text-[#121117] dark:text-white truncate">{{ $name }}</h3>
                        <span class="px-2 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full">PRO</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Professional Translator</p>

                    <!-- Rating Display -->
                    <div class="flex items-center gap-3 mb-1">
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($rating))
                                    <span class="material-symbols-outlined text-yellow-400 text-sm star-filled">star</span>
                                @elseif($i <= ceil($rating))
                                    <span class="material-symbols-outlined text-yellow-400 text-sm">star_half</span>
                                @else
                                    <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-sm">star</span>
                                @endif
                            @endfor
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">{{ $rating }}</span>
                        </div>
                        <span class="text-xs text-gray-500">•</span>
                        <span class="text-xs text-gray-500">({{ $reviews }} sharhlar)</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4 leading-relaxed">
                {!! $description !!}
            </div>

            <!-- Languages Section -->
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Tillar:</span>
                @foreach($languages as $index => $lang)
                    <span class="inline-flex items-center gap-1 rounded-lg bg-primary/10 px-3 py-1.5 text-xs font-semibold text-primary">
                        {{ $lang }}
                    </span>
                    @if($index == 2 && count($languages) > 3)
                        <span class="inline-flex items-center rounded-lg bg-gray-100 dark:bg-gray-700 px-3 py-1.5 text-xs font-medium text-gray-600 dark:text-gray-300">
                            +{{ count($languages) - 3 }} ko'proq
                        </span>
                        @break
                    @endif
                @endforeach
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <form method="POST" action="{{ route('translator.show', $id) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-primary hover:bg-primary/90 px-4 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200">
                        <span class="material-symbols-outlined text-sm mr-2">arrow_forward</span>
                        Profilni ko'rish
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
