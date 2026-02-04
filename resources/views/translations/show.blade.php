@extends('layouts.app')

@section('title', 'Tarjimalar - ' . $translationData['title'])

@section('content')
    <main class="flex-grow flex flex-col items-center py-6 px-4 md:px-8 max-w-[1280px] mx-auto w-full gap-6">
        {{-- Translation Header Section --}}
        @include('translations.partials.translation-header', ['translation' => $translationData])

        {{-- PDF Preview Section --}}
        @include('translations.partials.pdf-preview', [
            'filename' => $translationData['title'] . '.pdf',
            'currentPage' => 1,
            'totalPages' => $translationData['total_pages'],
            'isPurchased' => false,
            'pdfPath' => $translationData['preview_pdf_path'] ?? '/book.pdf'
        ])

        {{-- Reviews and Translator Info Section --}}
        <section class="w-full grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                @include('translations.partials.rating-section', ['translation' => $translationData])
                @include('translations.partials.translator-info', ['translation' => $translationData])
            </div>

            {{-- Reviews List --}}
            <div class="lg:col-span-2 space-y-4">
                <h3 class="font-bold text-lg hidden lg:block mb-2">So'nggi fikrlar</h3>

                @if(count($recentReviews) > 0)
                    @foreach($recentReviews as $review)
                        @include('translations.partials.review-card', ['review' => $review])
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <div class="bg-gray-100 dark:bg-gray-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-gray-400 text-2xl">rate_review</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Hozircha fikrlar yo'q</h3>
                        <p class="text-gray-500">Bu tarjima hali baholanmagan.</p>
                    </div>
                @endif

                @if(count($recentReviews) > 0)
                    <button class="w-full py-3 text-center text-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition border border-dashed border-gray-300 dark:border-gray-700">
                        Barcha fikrlarni ko'rish ({{ $translationData['total_reviews'] }})
                    </button>
                @endif
            </div>
        </section>

        {{-- Related Translations --}}
        @if(count($relatedTranslations) > 0)
            @include('translations.partials.related-works', ['relatedTranslations' => $relatedTranslations])
        @endif
    </main>
@endsection
