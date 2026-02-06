@extends('layouts.app')

@section('title', 'LadyLingua - Tarjimalar Ro\'yxati')

@section('content')
    <!-- Enhanced Hero Section -->
    <div class="bg-gradient-to-br from-primary/5 to-purple-600/5 border-b border-gray-100 dark:border-gray-800">
        <section class="w-full max-w-[1200px] mx-auto px-6 lg:px-8 py-16">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-6">
                    <span class="material-symbols-outlined text-lg">auto_stories</span>
                    Sifatli tarjimalar
                </div>
                <h1 class="text-[#121117] dark:text-white text-5xl font-black leading-tight tracking-tight mb-4">
                    Tarjimalar <span class="text-primary">Kutubxonasi</span>
                </h1>
                <p class="text-gray-600 dark:text-gray-400 text-xl leading-relaxed mb-8">
                    Professional tarjimonlar tomonidan tayyorlangan yuqori sifatli tarjimalarni kashf eting va o'zingiz uchun mosini toping.
                </p>

                <!-- Enhanced Search and Filter Bar -->

            </div>
        </section>
    </div>

    <!-- Main Content -->
    <section class="w-full max-w-[1200px] mx-auto px-6 lg:px-8 py-12">
        <!-- Results Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
            <div class="flex items-center gap-4 mb-4 sm:mb-0">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tarjimalar</h2>
                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-full text-sm font-medium">
                    {{ isset($translations) ? $translations->total() : 0 }} natija
                </span>
                @if(request('search'))
                    <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm font-medium">
                        "{{ request('search') }}" uchun
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center bg-gray-100 dark:bg-gray-800 rounded-lg p-1">
                    <button class="px-3 py-1.5 bg-white dark:bg-gray-700 shadow-sm rounded-md text-sm font-medium text-gray-700 dark:text-gray-300" title="Ro'yxat ko'rinishi">
                        <span class="material-symbols-outlined text-lg">view_list</span>
                    </button>
                    <button class="px-3 py-1.5 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" title="Grid ko'rinishi">
                        <span class="material-symbols-outlined text-lg">grid_view</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Enhanced Translation Cards -->
        <div class="space-y-0 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden bg-white dark:bg-gray-900 shadow-sm">
            @forelse($translations as $translation)
                @include('translations.partials.translation-item', [
                    'id' => $translation['id'],
                    'title' => $translation['title'],
                    'language' => $translation['language'],
                    'description' => $translation['description'],
                    'translator' => $translation['translator'],
                    'rating' => $translation['rating'],
                    'time' => $translation['time'],
                    'avatar' => $translation['avatar']
                ])
            @empty
                <!-- Enhanced Empty State -->
                <div class="p-16 text-center">
                    <div class="relative mx-auto w-24 h-24 mb-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-purple-600/20 rounded-full animate-pulse"></div>
                        <div class="relative w-full h-full rounded-full bg-gradient-to-br from-primary/10 to-purple-600/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-4xl text-primary/60">translate</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-3">Hozircha tarjimalar yo'q</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-lg mb-8 max-w-md mx-auto">
                        Yangi tarjimalar tez orada paydo bo'ladi! Bizning professional tarjimonlarimiz sizning kerakli kontentingizni tayyorlayapti.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button class="px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors font-semibold">
                            Yangi tarjima buyurtma berish
                        </button>
                        <a href="{{ route('translators') }}" class="px-6 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors font-semibold">
                            Tarjimonlarni ko'rish
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @include('translations.partials.pagination')
    </section>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Enhanced animation for translation items */
    .translation-item {
        position: relative;
        overflow: hidden;
    }

    .translation-item:hover {
        transform: translateY(-1px);
    }

    /* Smooth star animation */
    .star-filled {
        animation: starGlow 2s ease-in-out infinite;
    }

    @keyframes starGlow {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    /* Button hover enhancement */
    .group/btn:hover {
        transform: translateY(-1px);
    }

    /* Search input focus enhancement */
    input:focus, select:focus {
        transform: scale(1.01);
    }

    /* Custom select dropdown styling */
    select {
        background-image: none !important;
    }

    select::-ms-expand {
        display: none;
    }

    /* Fix for dropdown arrow positioning */
    .relative select {
        padding-right: 2.5rem;
    }

    .relative .material-symbols-outlined {
        pointer-events: none;
        z-index: 1;
    }

    /* Loading state for future use */
    .loading-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* Dark mode shimmer */
    .dark .loading-shimmer {
        background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
        background-size: 200% 100%;
    }

    /* Form submission animation */
    form:has(button:active) {
        opacity: 0.9;
        transition: opacity 0.2s ease;
    }

    /* Search result highlight */
    .search-highlight {
        background: linear-gradient(120deg, transparent 0%, rgba(59, 130, 246, 0.1) 50%, transparent 100%);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced search functionality
    const searchForm = document.querySelector('form[method="GET"]');
    const searchInput = document.querySelector('input[name="search"]');
    const languageSelect = document.querySelector('select[name="language"]');
    const sortSelect = document.querySelector('select[name="sort"]');
    const searchButton = searchForm?.querySelector('button[type="submit"]');

    // Auto-submit form on select change (for better UX)
    if (languageSelect) {
        languageSelect.addEventListener('change', function() {
            searchForm.submit();
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            searchForm.submit();
        });
    }

    // Enhanced search input handling
    if (searchInput) {
        // Submit on Enter key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchForm.submit();
            }
        });
    }

    // Enhanced search button interaction
    if (searchButton) {
        searchButton.addEventListener('click', function(e) {
            // Add loading state
            this.disabled = true;
            this.innerHTML = '<span class="material-symbols-outlined animate-spin">hourglass_empty</span> Qidirilmoqda...';

            // Re-enable after form submission
            setTimeout(() => {
                this.disabled = false;
                this.innerHTML = '<span class="material-symbols-outlined">search</span> Qidirish';
            }, 1000);
        });
    }

    // View toggle functionality
    const viewToggleBtns = document.querySelectorAll('.flex.items-center.bg-gray-100 button');
    viewToggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            viewToggleBtns.forEach(b => {
                b.classList.remove('bg-white', 'dark:bg-gray-700', 'shadow-sm');
                b.classList.add('hover:bg-gray-200', 'dark:hover:bg-gray-600');
            });

            // Add active class to clicked button
            this.classList.add('bg-white', 'dark:bg-gray-700', 'shadow-sm');
            this.classList.remove('hover:bg-gray-200', 'dark:hover:bg-gray-600');
        });
    });

    // Smooth animation on scroll for translation items
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Apply animation to translation items
    document.querySelectorAll('.translation-item').forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(item);
    });

    // Enhanced button interactions
    document.querySelectorAll('button, a').forEach(element => {
        if (element.classList.contains('bg-primary') || element.textContent.includes('O\'qishni boshlash')) {
            element.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });

            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        }
    });

    // Pagination smooth scrolling with search parameter preservation
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function(e) {
            // Add smooth transition effect
            document.body.style.opacity = '0.95';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 300);
        });
    });
});
</script>
@endpush


