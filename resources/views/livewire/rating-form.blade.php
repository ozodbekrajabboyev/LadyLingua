<div class="bg-white dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
    <h3 class="text-lg font-bold text-[#121117] dark:text-white mb-4">Fikrlar va Baholar</h3>

    {{-- Rating Display --}}
    <div class="flex items-end gap-2 mb-2">
        <span class="text-5xl font-bold text-[#121117] dark:text-white">{{ number_format($averageRating, 1) }}</span>
        <div class="pb-2 text-yellow-500 flex text-xl">
            @php
                $rating = (float)$averageRating;
                $fullStars = floor($rating);
                $hasHalfStar = ($rating - $fullStars) >= 0.5;
                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
            @endphp

            @for($i = 0; $i < $fullStars; $i++)
                <span class="material-symbols-outlined star-filled">star</span>
            @endfor

            @if($hasHalfStar)
                <span class="material-symbols-outlined star-filled" style="font-variation-settings: 'FILL' 0.5;">star_half</span>
            @endif

            @for($i = 0; $i < $emptyStars; $i++)
                <span class="material-symbols-outlined">star</span>
            @endfor
        </div>
    </div>
    <p class="text-sm text-gray-500 mb-6">{{ $totalRatings }} ta foydalanuvchi baholagan</p>

    <hr class="border-gray-100 dark:border-gray-800 mb-6"/>

    {{-- Review Form --}}
    @if(!$canRate && !$existingRating)
        @auth
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-4">
                <p class="text-yellow-800 dark:text-yellow-200 text-sm">
                    <span class="material-symbols-outlined text-yellow-600 text-sm mr-1">info</span>
                    Siz bu tarjimani baholay olmaysiz.
                </p>
            </div>
        @else
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                <p class="text-blue-800 dark:text-blue-200 text-sm">
                    <span class="material-symbols-outlined text-blue-600 text-sm mr-1">login</span>
                    Baholash uchun <a href="/platform/login" class="font-bold underline">tizimga kiring</a>.
                </p>
            </div>
        @endauth
    @endif

    @if($existingRating)
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
            <p class="text-blue-800 dark:text-blue-200 text-sm">
                <span class="material-symbols-outlined text-blue-600 text-sm mr-1">edit</span>
                Siz bu tarjimani {{ $existingRating->stars }} yulduz bilan baholagansiz. Bahoni o'zgartirishingiz mumkin.
            </p>
        </div>
    @endif

    @if($canRate)
        <form wire:submit.prevent="submitRating">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                O'z fikringizni qoldiring
            </label>

            {{-- Success Message --}}
            @if($showSuccess)
                <div class="bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-4 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-green-600 text-sm mr-2">check_circle</span>
                            {{ $successMessage }}
                        </div>
                        <button wire:click="hideSuccessMessage" class="text-green-600 hover:text-green-800">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Error Messages --}}
            @error('auth')
                <div class="bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-4">
                    {{ $message }}
                </div>
            @enderror

            @error('permission')
                <div class="bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-300 dark:border-yellow-700 text-yellow-700 dark:text-yellow-300 px-4 py-3 rounded-lg mb-4">
                    {{ $message }}
                </div>
            @enderror

            @error('duplicate')
                <div class="bg-orange-100 dark:bg-orange-900/30 border border-orange-300 dark:border-orange-700 text-orange-700 dark:text-orange-300 px-4 py-3 rounded-lg mb-4">
                    {{ $message }}
                </div>
            @enderror

            @error('general')
                <div class="bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-4">
                    {{ $message }}
                </div>
            @enderror

            {{-- Star Rating Input --}}
            <div class="flex gap-1 text-gray-300 mb-3">
                @for($i = 1; $i <= 5; $i++)
                    <button type="button"
                            wire:click="setRating({{ $i }})"
                            class="material-symbols-outlined text-2xl transition-all duration-200 hover:scale-110 focus:outline-none
                                   {{ $stars >= $i ? 'text-yellow-500 star-filled' : 'text-gray-300 hover:text-yellow-400' }}">
                        star
                    </button>
                @endfor
            </div>

            @error('stars')
                <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
            @enderror

            {{-- Review Text --}}
            <textarea
                wire:model.defer="comment"
                class="w-full bg-[#f1f0f4] dark:bg-gray-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary mb-3 resize-none h-24 transition-all"
                placeholder="Tarjima sifati haqida nima deysiz? (ixtiyoriy)"
                {{ $isSubmitting ? 'disabled' : '' }}
            ></textarea>

            @error('comment')
                <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
            @enderror

            {{-- Submit Button --}}
            <button
                type="submit"
                {{ $isSubmitting || $stars == 0 ? 'disabled' : '' }}
                class="w-full bg-primary hover:bg-primary/90 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium py-3 rounded-lg transition-all duration-200 flex items-center justify-center">

                @if($isSubmitting)
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
                    {{ $existingRating ? 'Yangilan...' : 'Yuborilmoqda...' }}
                @else
                    <span class="material-symbols-outlined text-sm mr-2">{{ $existingRating ? 'edit' : 'send' }}</span>
                    {{ $existingRating ? 'Bahoni yangilash' : 'Baholash' }}
                @endif
            </button>
        </form>
    @endif

    {{-- JavaScript for hiding success message --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('hide-success-message', () => {
                setTimeout(() => {
                    @this.hideSuccessMessage();
                }, 3000);
            });
        });
    </script>
</div>
