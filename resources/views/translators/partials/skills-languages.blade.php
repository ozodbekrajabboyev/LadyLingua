{{-- Skills and Languages Section - Database Data Only --}}
<div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl p-6">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-primary">language</span>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ko'nikmalar</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tillar va ma'lumotlar</p>
        </div>
    </div>

    <div class="space-y-6">
        {{-- Languages - Real Database Data --}}
        <div>
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 uppercase tracking-wide">Tillar</h4>
            <div class="flex flex-wrap gap-2">
                @foreach($translator['languages'] as $language)
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-primary/10 to-purple-600/10 text-primary border border-primary/20 font-medium">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        {{ $language }}
                    </span>
                @endforeach
            </div>
        </div>

        {{-- Contact Information - Real Database Data --}}
        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 uppercase tracking-wide">Ma'lumotlar</h4>
            <div class="space-y-3">
                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined text-lg text-gray-400">email</span>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 dark:text-white">Email</div>
                        <div>{{ $translator['email'] }}</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined text-lg text-gray-400">calendar_today</span>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 dark:text-white">A'zolik</div>
                        <div>{{ $translator['member_since'] }}dan beri faol</div>
                    </div>
                </div>

                @if(isset($translator['total_earnings']) && $translator['total_earnings'] > 0)
                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined text-lg text-gray-400">account_balance_wallet</span>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 dark:text-white">Jami daromad</div>
                        <div>${{ number_format($translator['total_earnings'], 2) }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
