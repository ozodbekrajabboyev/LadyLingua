{{-- Skills and Languages Section --}}
<section class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl p-6">
    <h2 class="text-lg font-bold text-[#121117] dark:text-white mb-4">Ko'nikmalar va Tillar</h2>

    <div class="space-y-4">
        {{-- Languages --}}
        <div>
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tillar</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($translator['languages'] as $language)
                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium text-primary ring-1 ring-inset ring-indigo-700/10 dark:bg-indigo-900/30">
                        {{ $language }}
                    </span>
                @endforeach
            </div>
        </div>

        {{-- Contact Info --}}
        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Aloqa</h3>
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined text-[18px]">email</span>
                    <span>{{ $translator['email'] }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    <span>{{ $translator['member_since'] }}dan beri a'zo</span>
                </div>
            </div>
        </div>
    </div>
</section>
