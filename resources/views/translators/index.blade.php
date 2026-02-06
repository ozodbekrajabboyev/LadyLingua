@extends('layouts.app')

@section('title', 'Tarjimonlar Ro\'yxati - LadyLingua')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 translators-page-content">
    <!-- Header Section with Stats -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-12">
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-purple-600 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-2xl">group</span>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-[#121117] dark:text-white tracking-tight">Tarjimonlar</h1>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">Tajribali va saralangan tarjimonlar hamjamiyati</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl px-6 py-4 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400">verified</span>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#121117] dark:text-white">{{ $translators->total() }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Faol tarjimonlar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('translators.partials.search-filters')

    <!-- Sort and View Options -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Saralash:</span>
            <select name="sort" onchange="updateSorting(this)" class="rounded-lg border border-gray-200 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-primary transition-all">
                <option value="rating" {{ request('sort', 'rating') == 'rating' ? 'selected' : '' }}>Reyting bo'yicha</option>
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Ism bo'yicha</option>
                <option value="reviews" {{ request('sort') == 'reviews' ? 'selected' : '' }}>Sharhlar soni bo'yicha</option>
                <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Yangi qo'shilganlar</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500 dark:text-gray-400">Ko'rinish:</span>
            <div class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                <button class="view-toggle active p-2 rounded-md transition-all duration-200 bg-white dark:bg-gray-600 shadow-sm">
                    <span class="material-symbols-outlined text-lg">view_list</span>
                </button>
                <button class="view-toggle p-2 rounded-md transition-all duration-200 text-gray-500 hover:text-gray-700">
                    <span class="material-symbols-outlined text-lg">grid_view</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Translators Grid -->
    <div id="translators-container" class="space-y-6 mb-12">
        @forelse($translators as $translator)
            @include('translators.partials.translator-card', [
                'id' => $translator['id'],
                'name' => $translator['name'],
                'avatar' => $translator['avatar'],
                'rating' => $translator['rating'],
                'reviews' => $translator['reviews'],
                'description' => $translator['description'],
                'languages' => $translator['languages']
            ])
        @empty
            <!-- Enhanced Empty State -->
            <div class="text-center py-20">
                <div class="relative mx-auto w-32 h-32 mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-purple-600/20 rounded-full animate-pulse"></div>
                    <div class="relative w-full h-full rounded-full bg-gradient-to-br from-primary/10 to-purple-600/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-6xl text-primary/60">search_off</span>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">Tarjimonlar topilmadi</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">Afsuski, qidiruv mezonlaringizga mos tarjimonlar topilmadi. Filtrlarni o'zgartirib ko'ring yoki yana keyinroq tashrif buyuring.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <button onclick="clearFilters()" class="px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary/90 transition-all duration-200 flex items-center gap-2">
                        <span class="material-symbols-outlined">refresh</span>
                        Filtrlarni tozalash
                    </button>
                    <a href="/translations" class="px-6 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                        Tarjimalarni ko'rish
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @include('translators.partials.pagination')
</div>

<!-- Mobile Navigation -->
@include('translators.partials.mobile-navigation')

<!-- Loading Overlay -->
<div id="loading-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-sm mx-4 text-center">
        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <div class="w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
        </div>
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Qidiruv amalga oshirilmoqda...</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Iltimos, kuting</p>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/translators-enhanced.js') }}"></script>
<script>
// Global utility functions
window.clearFilters = function() {
    window.location.href = "{{ route('translators') }}";
};

// Sorting function
window.updateSorting = function(selectElement) {
    const url = new URL(window.location);
    url.searchParams.set('sort', selectElement.value);
    window.location.href = url.toString();
};

// Initialize tooltips and other UI components
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });

    // Add translator card classes for animations
    document.querySelectorAll('[class*="translator-card"]').forEach((card, index) => {
        card.classList.add('translator-card');
        card.style.animationDelay = `${index * 100}ms`;
    });
});

function showTooltip(event) {
    const tooltip = document.createElement('div');
    tooltip.className = 'absolute z-50 px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg';
    tooltip.textContent = event.target.dataset.tooltip;

    document.body.appendChild(tooltip);

    const rect = event.target.getBoundingClientRect();
    tooltip.style.top = `${rect.top - tooltip.offsetHeight - 5}px`;
    tooltip.style.left = `${rect.left + (rect.width - tooltip.offsetWidth) / 2}px`;

    event.target.tooltipElement = tooltip;
}

function hideTooltip(event) {
    if (event.target.tooltipElement) {
        event.target.tooltipElement.remove();
        delete event.target.tooltipElement;
    }
}
</script>
@endpush

