<tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
    <td class="px-6 py-4">
        <div class="flex flex-col">
            <span class="font-medium text-[#121117] dark:text-white">{{ $title }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">ID: {{ $id }}</span>
        </div>
    </td>
    <td class="px-6 py-4">
        @if($translator)
            <div class="flex items-center gap-3">
                @if($avatar)
                    <div class="size-8 rounded-full bg-cover bg-center" style="background-image: url('{{ $avatar }}');"></div>
                @else
                    <div class="flex size-8 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-xs font-bold text-gray-500 dark:text-gray-300">
                        {{ substr($translator, 0, 1) }}
                    </div>
                @endif
                <span class="text-sm text-[#121117] dark:text-white">{{ $translator }}</span>
            </div>
        @else
            <div class="flex items-center gap-3">
                <div class="flex size-8 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-xs font-bold text-gray-500 dark:text-gray-300">
                    ?
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400 italic">Belgilanmagan</span>
            </div>
        @endif
    </td>
    <td class="px-6 py-4">
        @if($status === 'progress')
            <span class="inline-flex items-center rounded-full bg-primary/10 px-2.5 py-1 text-xs font-medium text-primary ring-1 ring-inset ring-primary/20">
            <span class="mr-1.5 size-1.5 rounded-full bg-primary"></span>
            Jarayonda
        </span>
        @elseif($status === 'pending')
            <span class="inline-flex items-center rounded-full bg-amber-50 dark:bg-amber-900/20 px-2.5 py-1 text-xs font-medium text-amber-600 dark:text-amber-400 ring-1 ring-inset ring-amber-500/20 dark:ring-amber-500/30">
            <span class="mr-1.5 size-1.5 rounded-full bg-amber-500"></span>
            Kutilmoqda
        </span>
        @elseif($status === 'completed')
            <span class="inline-flex items-center rounded-full bg-emerald-50 dark:bg-emerald-900/20 px-2.5 py-1 text-xs font-medium text-emerald-600 dark:text-emerald-400 ring-1 ring-inset ring-emerald-600/20 dark:ring-emerald-500/30">
            <span class="mr-1.5 size-1.5 rounded-full bg-emerald-500"></span>
            Yakunlandi
        </span>
        @endif
    </td>
    <td class="px-6 py-4">
        <div class="flex flex-col">
            <span class="text-sm text-[#121117] dark:text-white">{{ $date }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $price }}</span>
        </div>
    </td>
    <td class="px-6 py-4 text-right">
        @if($action === 'visibility' && isset($translation_id) && $translation_id)
            {{-- Eye icon that redirects to translation page --}}
            <a href="{{ route('translation.show', $translation_id) }}"
               class="inline-block rounded p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-[#121117] dark:hover:text-white transition-colors">
                <span class="material-symbols-outlined text-[20px]">{{ $action }}</span>
            </a>
        @else
            {{-- Regular action button for other actions --}}
            <button class="rounded p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-[#121117] dark:hover:text-white transition-colors">
                <span class="material-symbols-outlined text-[20px]">{{ $action }}</span>
            </button>
        @endif
    </td>
</tr>
