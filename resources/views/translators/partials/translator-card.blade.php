<div class="group relative bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl p-5 transition-all hover:shadow-md hover:border-primary/30">
    <div class="flex flex-col sm:flex-row gap-5">
        <div class="flex-shrink-0">
            <div class="size-24 rounded-xl bg-gray-100 overflow-hidden ring-1 ring-gray-200">
                <img alt="{{ $name }}" class="h-full w-full object-cover" src="{{ $avatar }}">
            </div>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-2 mb-1">
                <div>
                    <h3 class="text-lg font-bold text-[#121117] dark:text-white truncate">{{ $name }}</h3>
                    <div class="flex items-center gap-2 mt-0.5">
                        <div class="flex items-center text-yellow-500">
                            <span class="material-symbols-outlined text-[18px] star-filled">star</span>
                            <span class="text-sm font-semibold ml-1">{{ $rating }}</span>
                        </div>
                        <span class="text-xs text-gray-500">({{ $reviews }} sharhlar)</span>
                    </div>
                </div>
                <button class="hidden sm:inline-flex items-center rounded-lg border border-gray-200 bg-white dark:bg-transparent dark:border-gray-600 px-3 py-1.5 text-sm font-semibold text-primary hover:bg-gray-50 transition-all">
                    Profilni ko'rish
                </button>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-3">
                {{ $description }}
            </p>
            <div class="flex flex-wrap items-center gap-2">
                @foreach($languages as $lang)
                    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-semibold text-primary ring-1 ring-inset ring-indigo-700/10 dark:bg-indigo-900/30">{{ $lang }}</span>
                @endforeach
            </div>
            <button class="w-full mt-4 sm:hidden inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white dark:bg-transparent px-3 py-2 text-sm font-semibold text-primary">
                Profilni ko'rish
            </button>
        </div>
    </div>
</div>
