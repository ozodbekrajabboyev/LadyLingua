@extends('layouts.app')

@section('title', 'LadyLingua - Tarjimalar Ro\'yxati')

@section('content')
    <section class="w-full max-w-[1200px] px-6 lg:px-40 py-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div class="max-w-xl">
                <h2 class="text-[#121117] dark:text-white text-4xl font-black leading-tight tracking-tight mb-2">
                    Tarjimalar Ro'yxati
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-lg">
                    Mavjud tarjimalarni ko'zdan kechiring va sifatli ishlarni kashf eting.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button class="flex items-center gap-2 px-4 py-2 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 transition-colors">
                    <span class="material-symbols-outlined text-lg">filter_list</span>
                    Saralash
                </button>
            </div>
        </div>

        <div class="space-y-0 border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden bg-white dark:bg-gray-900 shadow-sm">
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
                <div class="p-12 text-center">
                    <div class="h-16 w-16 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 mx-auto mb-4">
                        <span class="material-symbols-outlined text-4xl">translate</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Hozircha tarjimalar yo'q</h4>
                    <p class="text-gray-500">Yangi tarjimalar tez orada paydo bo'ladi!</p>
                </div>
            @endforelse
        </div>

        @include('translations.partials.pagination')
    </section>
@endsection
