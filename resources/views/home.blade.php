@extends('layouts.app')

@section('title', config('app.name', 'LadyLingo') . ' - Tarjimonlar va Kitobxonlar Platformasi')

@section('content')
    <x-hero-section />

    <section class="w-full max-w-[1200px] px-6 lg:px-40 py-12">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold text-[#121117] dark:text-white">So'nggi tarjimalar</h3>
            <a class="text-primary text-sm font-semibold hover:underline" href="#">Barchasini ko'rish</a>
        </div>

        @if(isset($latestTranslations) && $latestTranslations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
        @else
            <div class="text-center py-12">
                <div class="h-16 w-16 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl">translate</span>
                </div>
                <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Hozircha tarjimalar yo'q</h4>
                <p class="text-gray-500">Yangi tarjimalar tez orada paydo bo'ladi!</p>
            </div>
        @endif
    </section>
@endsection
