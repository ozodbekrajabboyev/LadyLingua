<div class="bg-white dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Tarjimon haqida</h4>

    {{-- Translator Info --}}
    <div class="flex items-center gap-3 mb-3">
        <div class="h-12 w-12 rounded-full bg-gray-200 overflow-hidden ring-1 ring-gray-200 relative">
            <img alt="{{ $translation['translator_name'] }}"
                 class="h-full w-full object-cover"
                 src="{{ $translation['translator_avatar'] }}"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold"
                 style="display:none;">
                {{ strtoupper(substr($translation['translator_name'], 0, 2)) }}
            </div>
        </div>
        <div>
            <p class="font-bold text-[#121117] dark:text-white">{{ $translation['translator_name'] }}</p>
            <p class="text-xs text-gray-500">Professional Tarjimon</p>
        </div>
    </div>

    {{-- Bio --}}
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
        {{ $translation['translator_name'] }} tomonidan yuqori sifatli tarjima.
    </p>

    {{-- View Profile Link --}}
    <form method="POST" action="{{ route('translator.show', $translation['translator_id']) }}">
        @csrf
        <button type="submit" class="w-full text-primary text-sm font-medium hover:underline text-left">
            Tarjimon profilini ko'rish →
        </button>
    </form>
</div>
