<tr class="group hover:bg-gradient-to-r hover:from-gray-50/50 hover:to-transparent dark:hover:from-gray-800/30 dark:hover:to-transparent transition-all duration-200 border-l-4 border-transparent hover:border-primary/50">
    <!-- Project Info -->
    <td class="px-6 py-5">
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-3">
                <div class="w-3 h-3 rounded-full bg-gradient-to-br from-primary to-purple-600"></div>
                <span class="font-bold text-[#121117] dark:text-white text-base group-hover:text-primary transition-colors">{{ $title }}</span>
            </div>
            <div class="flex items-center gap-2 text-xs">
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-full font-medium">
                    <span class="material-symbols-outlined text-xs">tag</span>
                    {{ $id }}
                </span>
                @if(isset($deadline))
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 rounded-full font-medium">
                        <span class="material-symbols-outlined text-xs">schedule</span>
                        Muddat: {{ $deadline }}
                    </span>
                @endif
            </div>
        </div>
    </td>

    <!-- Translator Info -->
    <td class="px-6 py-5">
        @if($translator)
            <div class="flex items-center gap-3">
                <div class="relative">
                    @if($avatar)
                        <div class="w-10 h-10 rounded-full bg-cover bg-center ring-2 ring-white dark:ring-gray-800 shadow-sm" style="background-image: url('{{ $avatar }}');"></div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full ring-2 ring-white dark:ring-gray-900"></div>
                    @else
                        <div class="flex w-10 h-10 items-center justify-center rounded-full bg-gradient-to-br from-primary to-purple-600 text-sm font-bold text-white ring-2 ring-white dark:ring-gray-800 shadow-sm">
                            {{ strtoupper(substr($translator, 0, 2)) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full ring-2 ring-white dark:ring-gray-900"></div>
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-semibold text-[#121117] dark:text-white">{{ $translator }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Professional Translator</span>
                </div>
            </div>
        @else
            <div class="flex items-center gap-3">
                <div class="flex w-10 h-10 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-400 shadow-sm">
                    <span class="material-symbols-outlined text-lg">person_off</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm text-gray-500 dark:text-gray-400 italic">Belgilanmagan</span>
                    <span class="text-xs text-gray-400">Kutilmoqda</span>
                </div>
            </div>
        @endif
    </td>

    <!-- Enhanced Status -->
    <td class="px-6 py-5">
        @if($status === 'progress')
            <div class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 px-4 py-2.5 shadow-sm">
                <div class="relative">
                    <span class="w-3 h-3 rounded-full bg-blue-500 inline-block animate-pulse"></span>
                    <span class="absolute inset-0 w-3 h-3 rounded-full bg-blue-500 animate-ping opacity-75"></span>
                </div>
                <span class="text-sm font-bold text-blue-700 dark:text-blue-300">Jarayonda</span>
            </div>
        @elseif($status === 'pending')
            <div class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 px-4 py-2.5 shadow-sm">
                <div class="w-3 h-3 rounded-full bg-amber-500 animate-pulse"></div>
                <span class="text-sm font-bold text-amber-700 dark:text-amber-300">Kutilmoqda</span>
            </div>
        @elseif($status === 'completed')
            <div class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 px-4 py-2.5 shadow-sm">
                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                <span class="text-sm font-bold text-emerald-700 dark:text-emerald-300">Yakunlandi</span>
            </div>
        @endif
    </td>

    <!-- Date & Price Info -->
    <td class="px-6 py-5">
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2 text-sm">
                <span class="material-symbols-outlined text-gray-400 text-sm">calendar_today</span>
                <span class="font-medium text-[#121117] dark:text-white">{{ $date }}</span>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <span class="material-symbols-outlined text-gray-400 text-sm">payments</span>
                <span class="font-semibold text-primary">{{ $price }}</span>
            </div>
        </div>
    </td>

    <!-- Simplified Actions -->
    <td class="px-6 py-5 text-right">
        <div class="flex items-center justify-end gap-2 relative">
            @if(isset($translation_id) && $translation_id)
                {{-- Show eye icon when translation is ready --}}
                <a href="{{ route('translation.show', $translation_id) }}"
                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all duration-200 hover:shadow-lg group/btn"
                   title="Tarjimani ko'rish">
                    <span class="material-symbols-outlined text-lg">visibility</span>
                </a>
            @else
                {{-- Show placeholder when no translation is available --}}
                <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-400 opacity-50"
                     title="Tarjima hali tayyor emas">
                    <span class="material-symbols-outlined text-lg">hourglass_empty</span>
                </div>
            @endif

            {{-- Status Indicator Badge --}}
            @if(isset($priority) && $priority === 'high')
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse" title="Shoshilinch"></div>
            @elseif(isset($priority) && $priority === 'medium')
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-orange-500 rounded-full" title="O'rtacha muhimlik"></div>
            @endif
        </div>
    </td>
</tr>
