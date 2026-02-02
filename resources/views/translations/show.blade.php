@extends('layouts.app')

@section('title', 'Tarjimalar - Alkimyogar')

@section('content')
    <main class="flex-grow flex flex-col items-center py-6 px-4 md:px-8 max-w-[1280px] mx-auto w-full gap-6">
        {{-- Book Header Section --}}
        @include('translations.partials.book-info')

        {{-- PDF Preview Section --}}
        @include('translations.partials.pdf-preview', [
            'filename' => 'Alkimyogar - Paulo Coelho.pdf',
            'currentPage' => 1,
            'totalPages' => 163,
            'isPurchased' => false,
            'pdfPath' => '/book.pdf'
        ])

        {{-- Reviews and Translator Info Section --}}
        <section class="w-full grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                @include('translations.partials.rating-section')
                @include('translations.partials.translator-info')
            </div>

            {{-- Reviews List --}}
            <div class="lg:col-span-2 space-y-4">
                <h3 class="font-bold text-lg hidden lg:block mb-2">So'nggi fikrlar</h3>

                @include('translations.partials.review-card', [
                    'initials' => 'MK',
                    'name' => 'Malika Karimova',
                    'time' => '2 soat oldin',
                    'rating' => 5,
                    'color' => 'blue',
                    'text' => 'Juda ajoyib tarjima! Asarning ruhiyatini to\'liq saqlab qolgan. Ayniqsa, cho\'pon va alkimyogar o\'rtasidagi suhbatlar juda chiroyli o\'girilgan. Rahmat!'
                ])

                @include('translations.partials.review-card', [
                    'initials' => 'BO',
                    'name' => 'Bekzod Oripov',
                    'time' => 'Kecha',
                    'rating' => 4,
                    'color' => 'green',
                    'text' => 'Yaxshi tarjima, lekin ba\'zi joylarida imlo xatolar uchrab turibdi. Tahrir qilinssa mukammal bo\'ladi. Umumiy ma\'noda o\'qishga arziydi.'
                ])

                @include('translations.partials.review-card', [
                    'initials' => 'SA',
                    'name' => 'Sardor Alimov',
                    'time' => '3 kun oldin',
                    'rating' => 5,
                    'color' => 'purple',
                    'text' => 'Azizbek aka har doimgidek o\'z ishining ustasi. Kitobni bir nafasda o\'qib chiqdim. PDF sifati ham juda yaxshi, ko\'zni charchatmaydi.'
                ])

                <button class="w-full py-3 text-center text-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition border border-dashed border-gray-300 dark:border-gray-700">
                    Barcha fikrlarni ko'rish (124)
                </button>
            </div>
        </section>
    </main>
@endsection
