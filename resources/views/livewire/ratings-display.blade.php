<div class="space-y-4">
    <h3 class="font-bold text-lg hidden lg:block mb-2">So'nggi fikrlar</h3>

    @if(count($this->ratings) > 0)
        @foreach($this->ratings as $review)
            <div class="bg-white dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 transition-all duration-200 hover:shadow-md">
                <div class="flex justify-between items-start mb-2">
                    {{-- User Info --}}
                    <div class="flex items-center gap-3">
                        @php
                            $colorClasses = [
                                'blue' => 'bg-blue-100 text-blue-600',
                                'green' => 'bg-green-100 text-green-600',
                                'purple' => 'bg-purple-100 text-purple-600',
                                'pink' => 'bg-pink-100 text-pink-600',
                                'yellow' => 'bg-yellow-100 text-yellow-600',
                                'red' => 'bg-red-100 text-red-600',
                            ];

                            $colors = array_keys($colorClasses);
                            $selectedColor = $colors[crc32($review['user_name']) % count($colors)];
                            $avatarColor = $colorClasses[$selectedColor];
                            $initials = strtoupper(substr($review['user_name'], 0, 2));
                        @endphp

                        <div class="h-10 w-10 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-sm">
                            {{ $initials }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="font-bold text-sm text-[#121117] dark:text-white">{{ $review['user_name'] }}</p>
                                @if($review['type'] === 'rating')
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-600 text-[10px] font-bold rounded-full uppercase">Baho</span>
                                @else
                                    <span class="px-2 py-0.5 bg-green-100 text-green-600 text-[10px] font-bold rounded-full uppercase">Izoh</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400">{{ $review['date'] }}</p>
                        </div>
                    </div>

                    {{-- Rating Stars - Only show for ratings, not for comments --}}
                    @if($review['type'] === 'rating')
                        <div class="flex text-yellow-500 text-sm">
                            @if($review['rating'] > 0)
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review['rating'])
                                        <span class="material-symbols-outlined star-filled text-[18px]">star</span>
                                    @else
                                        <span class="material-symbols-outlined text-[18px] text-gray-300">star</span>
                                    @endif
                                @endfor
                            @else
                                <span class="text-gray-400 text-xs">Baho berilmagan</span>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Review Text --}}
                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                    {{ $review['comment'] }}
                </p>
            </div>
        @endforeach

        {{-- Load More Button --}}
        @if($this->hasMoreRatings && !$showAll)
            <div class="text-center pt-4">
                <button
                    wire:click="loadMore"
                    class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center justify-center mx-auto">
                    <span class="material-symbols-outlined text-sm mr-2">expand_more</span>
                    Ko'proq ko'rish
                </button>
            </div>
        @endif

        {{-- Show All Reviews Button --}}
        @if($this->hasMoreRatings && !$showAll && count($this->ratings) >= 5)
            <div class="text-center pt-2">
                <button
                    wire:click="showAllReviews"
                    class="text-primary hover:text-primary/80 font-medium text-sm transition-colors">
                    Barcha fikrlarni ko'rish
                </button>
            </div>
        @endif

    @else
        <div class="text-center py-8">
            <div class="bg-gray-100 dark:bg-gray-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-gray-400 text-2xl">rate_review</span>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">Hali hech kim baho bermagan yoki izoh qoldirmagan</p>
            <p class="text-xs text-gray-400 dark:text-gray-500">Birinchi bo'lib o'z fikringizni bildiring!</p>
        </div>
    @endif

    {{-- Loading State --}}
    <div wire:loading wire:target="loadMore,showAllReviews,refreshRatings" class="text-center py-4">
        <div class="inline-flex items-center text-gray-500 text-sm">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-primary mr-2"></div>
            Yuklanmoqda...
        </div>
    </div>
</div>

{{-- Polling for real-time updates (every 30 seconds when page is active) --}}
<script>
    document.addEventListener('livewire:initialized', () => {
        // Listen for rating submissions from other components
        Livewire.on('rating-submitted', () => {
            @this.refreshRatings();
        });

        // Optional: Add polling for real-time updates from other users
        // setInterval(() => {
        //     if (document.visibilityState === 'visible') {
        //         @this.refreshRatings();
        //     }
        // }, 30000);
    });
</script>

