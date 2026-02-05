@if(isset($translators) && $translators->total() > 0)
    <!-- Results Summary -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-semibold text-gray-900 dark:text-white">{{ $translators->firstItem() ?? 0 }}</span>
                -
                <span class="font-semibold text-gray-900 dark:text-white">{{ $translators->lastItem() ?? 0 }}</span>
                dan
                <span class="font-semibold text-gray-900 dark:text-white">{{ $translators->total() }}</span>
                natija
            </div>
            @if($translators->hasPages())
                <span class="text-sm text-gray-400">•</span>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Sahifa <span class="font-semibold text-gray-900 dark:text-white">{{ $translators->currentPage() }}</span>
                    dan <span class="font-semibold text-gray-900 dark:text-white">{{ $translators->lastPage() }}</span>
                </div>
            @endif
        </div>

        <!-- Results per page selector -->
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-600 dark:text-gray-400">Ko'rsatish:</span>
            <select class="rounded-lg border-gray-200 dark:border-gray-600 text-sm bg-white dark:bg-gray-800 dark:text-white px-2 py-1 focus:ring-2 focus:ring-primary">
                <option value="5" {{ $translators->perPage() == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ $translators->perPage() == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ $translators->perPage() == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ $translators->perPage() == 50 ? 'selected' : '' }}>50</option>
            </select>
        </div>
    </div>

    @if($translators->hasPages())
        <!-- Enhanced Pagination Navigation -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <!-- Mobile-first: Simple prev/next -->
            <div class="flex sm:hidden items-center gap-3">
                @if ($translators->onFirstPage())
                    <button disabled class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                        Oldingi
                    </button>
                @else
                    <a href="{{ $translators->previousPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-primary hover:text-primary/80 transition-colors">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                        Oldingi
                    </a>
                @endif

                <span class="px-3 py-1 text-sm text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    {{ $translators->currentPage() }} / {{ $translators->lastPage() }}
                </span>

                @if ($translators->hasMorePages())
                    <a href="{{ $translators->nextPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-primary hover:text-primary/80 transition-colors">
                        Keyingi
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </a>
                @else
                    <button disabled class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">
                        Keyingi
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </button>
                @endif
            </div>

            <!-- Desktop: Full pagination -->
            <nav class="hidden sm:flex items-center gap-2">
                {{-- Previous Page Link --}}
                @if ($translators->onFirstPage())
                    <button disabled class="w-11 h-11 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-300 dark:text-gray-600 cursor-not-allowed bg-gray-50 dark:bg-gray-800">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </button>
                @else
                    <a href="{{ $translators->previousPageUrl() }}" class="w-11 h-11 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all duration-200">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $start = max($translators->currentPage() - 2, 1);
                    $end = min($start + 4, $translators->lastPage());
                    $start = max($end - 4, 1);
                @endphp

                {{-- First Page --}}
                @if($start > 1)
                    <a href="{{ $translators->url(1) }}" class="w-11 h-11 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all duration-200 font-medium">1</a>
                    @if($start > 2)
                        <span class="px-2 text-gray-400">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </span>
                    @endif
                @endif

                {{-- Page Range --}}
                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $translators->currentPage())
                        <button class="w-11 h-11 flex items-center justify-center rounded-xl bg-primary text-white font-bold shadow-sm ring-2 ring-primary/20">{{ $i }}</button>
                    @else
                        <a href="{{ $translators->url($i) }}" class="w-11 h-11 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all duration-200 font-medium">{{ $i }}</a>
                    @endif
                @endfor

                {{-- Last Page --}}
                @if($end < $translators->lastPage())
                    @if($end < $translators->lastPage() - 1)
                        <span class="px-2 text-gray-400">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </span>
                    @endif
                    <a href="{{ $translators->url($translators->lastPage()) }}" class="w-11 h-11 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all duration-200 font-medium">{{ $translators->lastPage() }}</a>
                @endif

                {{-- Next Page Link --}}
                @if ($translators->hasMorePages())
                    <a href="{{ $translators->nextPageUrl() }}" class="w-11 h-11 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all duration-200">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </a>
                @else
                    <button disabled class="w-11 h-11 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-300 dark:text-gray-600 cursor-not-allowed bg-gray-50 dark:bg-gray-800">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </button>
                @endif
            </nav>

            <!-- Quick jump to page -->
            <div class="hidden lg:flex items-center gap-2 ml-6">
                <span class="text-sm text-gray-500 dark:text-gray-400">Sahifaga o'tish:</span>
                <input type="number" min="1" max="{{ $translators->lastPage() }}" value="{{ $translators->currentPage() }}"
                       class="w-16 px-2 py-1 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-primary"
                       onchange="window.location.href='{{ $translators->url(1) }}'.replace('page=1', 'page=' + this.value)">
            </div>
        </div>
    @endif
@endif
