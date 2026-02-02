@extends('layouts.app')

@section('title', 'Buyurtmalarim - Tarjimonlar Platformasi')

@section('content')
    <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
        <div class="flex flex-col gap-2">
            <h1 class="text-3xl font-black leading-tight tracking-tight text-[#121117] dark:text-white md:text-4xl">Buyurtmalarim</h1>
            <p class="text-base text-gray-500 dark:text-gray-400">Faol va yakunlangan loyihalar ro'yxati</p>
        </div>
        <a href="{{ route('translations') }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-primary px-5 text-sm font-medium text-white transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Yangi buyurtma
        </a>
    </div>

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mt-8">
        <form method="GET" action="{{ route('orders') }}" class="relative w-full lg:max-w-md">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                <span class="material-symbols-outlined">search</span>
            </div>
            <input
                name="search"
                value="{{ request('search') }}"
                class="block w-full rounded-lg border-0 bg-white dark:bg-gray-900 py-3 pl-10 pr-4 text-sm text-[#121117] dark:text-white placeholder:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none"
                placeholder="Buyurtma raqami yoki loyiha nomini qidirish..."
                type="text"
                onchange="this.form.submit()">
        </form>
        <div class="flex gap-2 overflow-x-auto pb-2 lg:pb-0 scrollbar-hide">
            <a href="{{ route('orders', array_merge(request()->query(), ['status' => null])) }}"
               class="whitespace-nowrap rounded-lg {{ !request('status') || request('status') == 'all' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800' }} px-4 py-2 text-sm font-medium transition-colors">
                Barchasi
            </a>
            <a href="{{ route('orders', array_merge(request()->query(), ['status' => 'pending'])) }}"
               class="whitespace-nowrap rounded-lg {{ request('status') == 'pending' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800' }} px-4 py-2 text-sm font-medium transition-colors">
                Kutilmoqda
            </a>
            <a href="{{ route('orders', array_merge(request()->query(), ['status' => 'progress'])) }}"
               class="whitespace-nowrap rounded-lg {{ request('status') == 'progress' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800' }} px-4 py-2 text-sm font-medium transition-colors">
                Jarayonda
            </a>
            <a href="{{ route('orders', array_merge(request()->query(), ['status' => 'completed'])) }}"
               class="whitespace-nowrap rounded-lg {{ request('status') == 'completed' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800' }} px-4 py-2 text-sm font-medium transition-colors">
                Yakunlandi
            </a>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm overflow-hidden mt-8 mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Loyiha nomi</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Tarjimon</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Holat</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Sana / Narx</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400 text-right">Amal</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($orders as $order)
                    @include('orders.partials.order-row', $order)
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                <span class="material-symbols-outlined text-4xl mb-2">inbox</span>
                                <h3 class="text-lg font-medium text-[#121117] dark:text-white mb-1">Buyurtmalar topilmadi</h3>
                                <p class="text-sm">Hozircha hech qanday buyurtma yo'q yoki qidiruv bo'yicha natija topilmadi.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @include('orders.partials.table-pagination')
    </div>
@endsection
