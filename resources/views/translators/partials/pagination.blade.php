{{-- Debug Info (remove this later) --}}
@if(isset($translators))
    <div class="text-center text-sm text-gray-500 mb-4">
        Debug: Total {{ $translators->total() }} translators, Page {{ $translators->currentPage() }} of {{ $translators->lastPage() }}, Per page: {{ $translators->perPage() }}
    </div>
@endif

@if(isset($translators) && $translators->total() > 0)
    <div class="mt-12 flex justify-center">
        <nav class="flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($translators->onFirstPage())
                <button disabled class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-800 text-gray-300 dark:text-gray-600 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
            @else
                <a href="{{ $translators->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-800 text-gray-400 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">chevron_left</span>
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
                <a href="{{ $translators->url(1) }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-800 text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">1</a>
                @if($start > 2)
                    <span class="px-2 text-gray-400">...</span>
                @endif
            @endif

            {{-- Page Range --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $translators->currentPage())
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-primary text-white font-bold">{{ $i }}</button>
                @else
                    <a href="{{ $translators->url($i) }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-800 text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">{{ $i }}</a>
                @endif
            @endfor

            {{-- Last Page --}}
            @if($end < $translators->lastPage())
                @if($end < $translators->lastPage() - 1)
                    <span class="px-2 text-gray-400">...</span>
                @endif
                <a href="{{ $translators->url($translators->lastPage()) }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-800 text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">{{ $translators->lastPage() }}</a>
            @endif

            {{-- Next Page Link --}}
            @if ($translators->hasMorePages())
                <a href="{{ $translators->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-800 text-gray-400 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            @else
                <button disabled class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-800 text-gray-300 dark:text-gray-600 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            @endif
        </nav>
    </div>
@endif
