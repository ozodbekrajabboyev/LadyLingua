@extends('layouts.app')

@section('title', config('app.name', 'LadyLingo') . ' - Tarjimonlar va Kitobxonlar Platformasi')

@section('content')
    {{-- Live Search Hero Section --}}
    <livewire:search-translations />

    {{-- Latest Translations Section --}}
    <section class="w-full max-w-[1200px] px-4 sm:px-6 lg:px-40 py-8 lg:py-12">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 lg:mb-8 gap-4">
            <div>
                <h3 class="text-xl lg:text-2xl font-bold text-[#121117] dark:text-white mb-2">So'nggi tarjimalar</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Eng yangi va sifatli tarjimalar bilan tanishing</p>
            </div>
            <a class="inline-flex items-center gap-2 text-primary text-sm font-semibold hover:underline transition-all duration-200 hover:gap-3" href="/translations">
                <span>Barchasini ko'rish</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>

        @if(isset($latestTranslations) && $latestTranslations->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                @foreach($latestTranslations as $translation)
                    <x-translation-card
                        :title="$translation['title']"
                        :description="$translation['description']"
                        :language-from="$translation['language_from']"
                        :language-to="$translation['language_to']"
                        :rating="$translation['rating']"
                        :translator-name="$translation['translator_name']"
                        :translator-image="$translation['translator_image']"
                        :time-ago="$translation['time_ago']"
                        :price="$translation['price'] ?? null"
                        :translation-id="$translation['id'] ?? null"
                    />
                @endforeach
            </div>

            {{-- Show More Button for Mobile --}}
            <div class="flex justify-center mt-8 sm:hidden">
                <a href="/translations"
                   class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 text-primary border-2 border-primary px-6 py-3 rounded-xl font-semibold hover:bg-primary hover:text-white transition-all duration-300 shadow-lg">
                    <span>Ko'proq tarjimalar</span>
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12 lg:py-16">
                <div class="max-w-md mx-auto">
                    <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-primary/10 to-purple-100 dark:from-primary/20 dark:to-purple-900/20 flex items-center justify-center text-primary mx-auto mb-6">
                        <span class="material-symbols-outlined text-4xl">translate</span>
                    </div>
                    <h4 class="text-lg lg:text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">Hozircha tarjimalar yo'q</h4>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 leading-relaxed">Yangi va sifatli tarjimalar tez orada paydo bo'ladi! Bizning professional tarjimonlarimiz har doim faol ishlashmoqda.</p>

                    {{-- Call to Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                        <a href="/translators"
                           class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-all duration-200 shadow-lg shadow-primary/25">
                            <span class="material-symbols-outlined text-lg">group</span>
                            <span>Tarjimonlarni ko'rish</span>
                        </a>
                        @auth
                            <a href="/orders/create"
                               class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 text-primary border border-primary px-6 py-3 rounded-lg font-semibold hover:bg-primary/5 transition-all duration-200">
                                <span class="material-symbols-outlined text-lg">add</span>
                                <span>Buyurtma berish</span>
                            </a>
                        @else
                            <a href="/platform/login"
                               class="inline-flex items-center gap-2 text-primary font-semibold hover:underline transition-all duration-200">
                                <span>Kirish va buyurtma berish</span>
                                <span class="material-symbols-outlined text-lg">login</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endif
    </section>

    {{-- Features Section --}}
    <section class="w-full max-w-[1200px] px-4 sm:px-6 lg:px-40 py-8 lg:py-12 border-t border-gray-100 dark:border-gray-800">
        <div class="text-center mb-8 lg:mb-12">
            <h3 class="text-xl lg:text-2xl font-bold text-[#121117] dark:text-white mb-3">Nima uchun LadyLingo?</h3>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">Professional tarjima xizmatlari va yuqori sifat kafolati bilan tanishing</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <div class="text-center group">
                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-500/10 to-blue-600/20 flex items-center justify-center text-blue-600 mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-2xl">verified</span>
                </div>
                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Sifat kafolati</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Barcha tarjimalar professional tarjimonlar tomonidan tekshiriladi</p>
            </div>

            <div class="text-center group">
                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-green-500/10 to-green-600/20 flex items-center justify-center text-green-600 mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-2xl">schedule</span>
                </div>
                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Tez yetkazish</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Buyurtmalaringiz belgilangan vaqtda tayyor bo'ladi</p>
            </div>

            <div class="text-center group">
                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-500/10 to-purple-600/20 flex items-center justify-center text-purple-600 mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-2xl">support_agent</span>
                </div>
                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">24/7 yordam</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Har qanday savol yoki muammo bo'yicha yordam olasiz</p>
            </div>
        </div>
    </section>
@endsection

@push('head')
<style>
    /* Mobile-first responsive improvements */
    @media (max-width: 640px) {
        .translation-card {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            border-radius: 1rem;
        }

        .translation-card:hover {
            transform: translateY(-2px);
        }
    }

    /* Enhanced hover effects for desktop */
    @media (min-width: 1024px) {
        .translation-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
        }
    }
</style>
@endpush

