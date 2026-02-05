@if(isset($translations) && $translations->total() > 0)
    <div class="mt-12 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <!-- Results Info -->
        <div class="text-sm text-gray-600 dark:text-gray-400">
            <span class="font-medium">{{ $translations->firstItem() }}-{{ $translations->lastItem() }}</span>
            dan
            <span class="font-medium">{{ $translations->total() }}</span>
            ta natija ko'rsatilmoqda
            @if(request('search') || request('language') || request('sort'))
                <div class="mt-1 text-xs">
                    @if(request('search'))
                        <span class="inline-flex items-center px-2 py-1 bg-primary/10 text-primary rounded text-xs">
                            "{{ request('search') }}"
                        </span>
                    @endif
                    @if(request('language'))
                        <span class="inline-flex items-center px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs ml-1">
                            {{ request('language') }}
                        </span>
                    @endif
                </div>
            @endif
        </div>

        <!-- Pagination Navigation -->
        <nav class="flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($translations->onFirstPage())
                <button disabled class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-300 dark:text-gray-600 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
            @else
                <a href="{{ $translations->appends(request()->query())->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary/50 transition-all duration-200">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @php
                $start = max($translations->currentPage() - 2, 1);
                $end = min($start + 4, $translations->lastPage());
                $start = max($end - 4, 1);
            @endphp

            {{-- First Page --}}
            @if($start > 1)
                <a href="{{ $translations->appends(request()->query())->url(1) }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary/50 transition-all duration-200">1</a>
                @if($start > 2)
                    <span class="w-10 h-10 flex items-center justify-center text-gray-400">...</span>
                @endif
            @endif

            {{-- Page Numbers --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $translations->currentPage())
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-primary text-white border border-primary font-medium shadow-lg">{{ $i }}</button>
                @else
                    <a href="{{ $translations->appends(request()->query())->url($i) }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary/50 transition-all duration-200">{{ $i }}</a>
                @endif
            @endfor

            {{-- Last Page --}}
            @if($end < $translations->lastPage())
                @if($end < $translations->lastPage() - 1)
                    <span class="w-10 h-10 flex items-center justify-center text-gray-400">...</span>
                @endif
                <a href="{{ $translations->appends(request()->query())->url($translations->lastPage()) }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary/50 transition-all duration-200">{{ $translations->lastPage() }}</a>
            @endif

            {{-- Next Page Link --}}
            @if ($translations->hasMorePages())
                <a href="{{ $translations->appends(request()->query())->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary/50 transition-all duration-200">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            @else
                <button disabled class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-300 dark:text-gray-600 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            @endif
        </nav>
    </div>
@endif

