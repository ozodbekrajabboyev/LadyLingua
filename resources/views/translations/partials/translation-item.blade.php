<div class="news-list-item group flex flex-col md:flex-row gap-6 p-6 hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
    <div class="flex-shrink-0">
        <div class="h-16 w-16 rounded-2xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-4xl">description</span>
        </div>
    </div>
    <div class="flex-1 min-w-0">
        <div class="flex flex-wrap items-center gap-2 mb-2">
            <h3 class="text-xl font-bold text-[#121117] dark:text-white group-hover:text-primary transition-colors truncate">{{ $title }}</h3>
            <span class="px-3 py-0.5 bg-primary/10 text-primary text-[10px] font-bold rounded-full uppercase tracking-widest">{{ $language }}</span>
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-base leading-relaxed mb-4 line-clamp-2">
            {{ $description }}
        </p>
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-100 overflow-hidden ring-2 ring-white dark:ring-gray-800 relative">
                        <img alt="{{ $translator }}"
                             class="w-full h-full object-cover"
                             src="{{ $avatar }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold"
                             style="display:none;">
                            {{ strtoupper(substr($translator, 0, 2)) }}
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $translator }}</span>
                </div>
                <div class="h-4 w-px bg-gray-200 dark:bg-gray-700"></div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm star-filled">star</span>
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $rating }}</span>
                </div>
                <div class="h-4 w-px bg-gray-200 dark:bg-gray-700"></div>
                <span class="text-xs text-gray-400">{{ $time }}</span>
            </div>
            <form method="POST" action="{{ route('translation.show', $id) }}" class="inline">
                @csrf
                <button type="submit" class="text-primary text-sm font-bold hover:underline flex items-center gap-1">
                    Batafsil <span class="material-symbols-outlined text-lg">chevron_right</span>
                </button>
            </form>
        </div>
    </div>
</div>
