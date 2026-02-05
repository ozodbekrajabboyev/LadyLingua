@if($orders->hasPages())
<div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 px-6 py-6">
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-gray-400">info</span>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-semibold text-[#121117] dark:text-white">{{ $orders->firstItem() ?? 0 }}</span>
                -
                <span class="font-semibold text-[#121117] dark:text-white">{{ $orders->lastItem() ?? 0 }}</span>
                dan
                <span class="font-semibold text-primary">{{ $orders->total() }}</span>
                ta natija
            </p>
        </div>
        <div class="flex items-center gap-2">
            <nav class="flex items-center gap-1" aria-label="Pagination">
                {{-- Previous Button --}}
                @if($orders->previousPageUrl())
                    <a href="{{ $orders->appends(request()->query())->previousPageUrl() }}"
                       class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-primary hover:border-primary/50 transition-all duration-200 shadow-sm">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </a>
                @else
                    <button disabled
                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-600 cursor-not-allowed shadow-sm">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </button>
                @endif

                {{-- Page Numbers --}}
                @php
                    $start = max($orders->currentPage() - 2, 1);
                    $end = min($start + 4, $orders->lastPage());
                    $start = max($end - 4, 1);
                @endphp

                @if($start > 1)
                    <a href="{{ $orders->appends(request()->query())->url(1) }}"
                       class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-primary hover:border-primary/50 transition-all duration-200 shadow-sm font-medium">
                        1
                    </a>
                    @if($start > 2)
                        <span class="inline-flex items-center justify-center w-10 h-10 text-gray-400">...</span>
                    @endif
                @endif

                @for($i = $start; $i <= $end; $i++)
                    @if($i == $orders->currentPage())
                        <button class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary border border-primary text-white font-bold shadow-lg">
                            {{ $i }}
                        </button>
                    @else
                        <a href="{{ $orders->appends(request()->query())->url($i) }}"
                           class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-primary hover:border-primary/50 transition-all duration-200 shadow-sm font-medium">
                            {{ $i }}
                        </a>
                    @endif
                @endfor

                @if($end < $orders->lastPage())
                    @if($end < $orders->lastPage() - 1)
                        <span class="inline-flex items-center justify-center w-10 h-10 text-gray-400">...</span>
                    @endif
                    <a href="{{ $orders->appends(request()->query())->url($orders->lastPage()) }}"
                       class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-primary hover:border-primary/50 transition-all duration-200 shadow-sm font-medium">
                        {{ $orders->lastPage() }}
                    </a>
                @endif

                {{-- Next Button --}}
                @if($orders->nextPageUrl())
                    <a href="{{ $orders->appends(request()->query())->nextPageUrl() }}"
                       class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-primary hover:border-primary/50 transition-all duration-200 shadow-sm">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </a>
                @else
                    <button disabled
                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-600 cursor-not-allowed shadow-sm">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </button>
                @endif
            </nav>
        </div>
    </div>

    {{-- Mobile Pagination --}}
    <div class="flex flex-1 justify-between sm:hidden">
        @if($orders->previousPageUrl())
            <a href="{{ $orders->appends(request()->query())->previousPageUrl() }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-sm">chevron_left</span>
                Avvalgi
            </a>
        @else
            <button disabled
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed shadow-sm">
                <span class="material-symbols-outlined text-sm">chevron_left</span>
                Avvalgi
            </button>
        @endif

        <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $orders->currentPage() }}</span>
            <span class="text-sm text-gray-400">/</span>
            <span class="text-sm font-medium text-[#121117] dark:text-white">{{ $orders->lastPage() }}</span>
        </div>

        @if($orders->nextPageUrl())
            <a href="{{ $orders->appends(request()->query())->nextPageUrl() }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                Keyingi
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </a>
        @else
            <button disabled
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed shadow-sm">
                Keyingi
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </button>
        @endif
    </div>
</div>
@endif

{{-- Always show total count when no pagination --}}
@if(!$orders->hasPages() && $orders->total() > 0)
<div class="border-t border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 px-6 py-4">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-gray-400">info</span>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Jami <span class="font-semibold text-primary">{{ $orders->total() }}</span> ta buyurtma
        </p>
    </div>
</div>
@endif
