<div class="bg-white dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
    <h3 class="text-lg font-bold text-[#121117] dark:text-white mb-4">Izoh qoldiring</h3>

    @auth
        {{-- Success Message --}}
        @if($showSuccess)
            <div class="bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-4 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-green-600 text-sm mr-2">check_circle</span>
                        Izohingiz muvaffaqiyatli qo'shildi!
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

        @error('general')
            <div class="bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-4">
                {{ $message }}
            </div>
        @enderror

        <form wire:submit.prevent="submitComment">
            {{-- Comment Text --}}
            <textarea
                wire:model.defer="content"
                class="w-full bg-[#f1f0f4] dark:bg-gray-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary mb-3 resize-none h-24 transition-all"
                placeholder="Tarjima haqida o'z fikringizni bildiring..."
                {{ $isSubmitting ? 'disabled' : '' }}
            ></textarea>

            @error('content')
                <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
            @enderror

            {{-- Submit Button --}}
            <button
                type="submit"
                {{ $isSubmitting ? 'disabled' : '' }}
                class="w-full bg-primary hover:bg-primary/90 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium py-3 rounded-lg transition-all duration-200 flex items-center justify-center">

                @if($isSubmitting)
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
                    Yuborilmoqda...
                @else
                    <span class="material-symbols-outlined text-sm mr-2">send</span>
                    Izoh yuborish
                @endif
            </button>
        </form>
    @else
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <p class="text-blue-800 dark:text-blue-200 text-sm">
                <span class="material-symbols-outlined text-blue-600 text-sm mr-1">login</span>
                Izoh qoldirish uchun <a href="/platform/login" class="font-bold underline">tizimga kiring</a>.
            </p>
        </div>
    @endauth
</div>
