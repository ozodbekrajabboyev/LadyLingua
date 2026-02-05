@extends('layouts.app')

@section('title', $translatorData['name'] . ' - Professional Translator | LadyLingua')

@push('head')
    <meta name="description" content="View {{ $translatorData['name'] }}'s professional translator profile. Rating: {{ $translatorData['rating'] }}/5 with {{ $translatorData['reviews'] }} reviews.">
    <meta property="og:title" content="{{ $translatorData['name'] }} - Professional Translator">
    <meta property="og:description" content="Professional translator with {{ $translatorData['completed_projects'] }} completed projects and {{ $translatorData['rating'] }}/5 rating.">
@endpush

@section('main-classes', 'bg-gray-50 dark:bg-gray-900')

@section('content')
    <div class="min-h-screen pb-16 lg:pb-8">
        <!-- Enhanced Header with Breadcrumbs -->
        <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Breadcrumbs -->
                <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Bosh sahifa</a>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <a href="{{ route('translators') }}" class="hover:text-primary transition-colors">Tarjimonlar</a>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-gray-900 dark:text-white font-medium">{{ $translatorData['name'] }}</span>
                </nav>

                <!-- Back Button -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('translators') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-all duration-200">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        Orqaga qaytish
                    </a>

                    <!-- Quick Actions -->
                    <div class="flex items-center gap-3">
                        <button data-action="bookmark" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl transition-all duration-200">
                            <span class="material-symbols-outlined text-lg">bookmark_border</span>
                            Saqlash
                        </button>
                        <button class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl transition-all duration-200">
                            <span class="material-symbols-outlined text-lg">share</span>
                            Ulashish
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-8 space-y-8">
                    <!-- Profile Header -->
                    @include('translators.partials.profile-header', ['translator' => $translatorData])

                    <!-- Statistics -->
                    @include('translators.partials.profile-stats', ['translator' => $translatorData])

                    <!-- Completed Works -->
                    @include('translators.partials.completed-works', ['translations' => $completedTranslations])
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-6">
                    <!-- Skills and Languages -->
                    @include('translators.partials.skills-languages', ['translator' => $translatorData])

                    <!-- Reviews Summary -->
                    @include('translators.partials.reviews-summary', ['translator' => $translatorData])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bookmark functionality
    document.querySelectorAll('[data-action="bookmark"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('.material-symbols-outlined');
            if (icon.textContent === 'bookmark_border') {
                icon.textContent = 'bookmark';
                this.classList.add('text-primary', 'border-primary/50');
                showToast('Tarjimon saqlandi!', 'success');
            } else {
                icon.textContent = 'bookmark_border';
                this.classList.remove('text-primary', 'border-primary/50');
                showToast('Tarjimon saqlanganlardan olib tashlandi', 'info');
            }
        });
    });

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
            type === 'success' ? 'bg-green-500' : 'bg-blue-500'
        }`;
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
});
</script>
@endpush

