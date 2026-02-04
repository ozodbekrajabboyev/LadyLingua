@extends('layouts.app')

@section('title', 'Tarjimonlar Ro\'yxati - LadyLingua')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-[#121117] dark:text-white tracking-tight">Tarjimonlar</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Tajribali va saralangan tarjimonlar hamjamiyati</p>
        </div>
    </div>

    <div class="mb-8">
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="material-symbols-outlined text-gray-400">search</span>
            </div>
            <input class="block w-full rounded-xl border-0 py-3 pl-10 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 bg-white dark:bg-gray-900 dark:ring-gray-700 dark:text-white shadow-sm" placeholder="Tarjimonning ismi yoki sohasi bo'yicha qidirish..." type="text">
        </div>
    </div>

    <div class="space-y-4 mb-12">
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
            <div class="text-center py-12">
                <div class="h-16 w-16 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl">person</span>
                </div>
                <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Hozircha tarjimonlar yo'q</h4>
                <p class="text-gray-500">Yangi tarjimonlar tez orada qo'shiladi!</p>
            </div>
        @endforelse
    </div>

    @include('translators.partials.pagination')
@endsection
