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
                {{-- Live Rating Form Component --}}
                <livewire:rating-form :translation-id="$translationData['id']" />

                {{-- Live Comment Form Component --}}
                <livewire:comment-form :translation-id="$translationData['id']" />

                @include('translations.partials.translator-info', ['translation' => $translationData])
            </div>

            {{-- Live Reviews List Component --}}
            <div class="lg:col-span-2">
                <livewire:ratings-display :translation-id="$translationData['id']" />
            </div>
        </section>

        {{-- Related Translations --}}
        @if(count($relatedTranslations) > 0)
            @include('translations.partials.related-works', ['relatedTranslations' => $relatedTranslations])
        @endif
    </main>
@endsection
