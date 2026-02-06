@extends('layouts.app')

@section('title', 'Buyurtmalarim - Tarjimonlar Platformasi')

@section('content')
    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="material-symbols-outlined text-green-400">check_circle</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Error Message --}}
    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="material-symbols-outlined text-red-400">error</span>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Xatoliklar mavjud</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Enhanced Hero Section -->
    <div class="bg-gradient-to-br from-primary/5 to-purple-600/5 border-b border-gray-100 dark:border-gray-800 mb-8 -mx-6 lg:-mx-8 px-6 lg:px-8 py-12">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <div class="flex flex-col gap-3">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold w-fit mb-2">
                        <span class="material-symbols-outlined text-lg">assignment</span>
                        Buyurtmalar boshqaruvi
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black leading-tight tracking-tight text-[#121117] dark:text-white">
                        Mening <span class="text-primary">Buyurtmalarim</span>
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400">Faol va yakunlangan loyihalar ro'yxatini boshqaring</p>
                </div>
                <a href="{{ route('orders.create') }}"
                   class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-primary px-6 text-base font-semibold text-white transition-all duration-200 hover:bg-primary/90 hover:shadow-lg hover:shadow-primary/25 focus:outline-none focus:ring-2 focus:ring-primary/50">
                    <span class="material-symbols-outlined text-xl">add_circle</span>
                    Yangi buyurtma berish
                </a>
            </div>
        </div>
    </div>

    <!-- Enhanced Search and Filter Section -->
    <div class="mb-8">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col lg:flex-row gap-6 lg:items-center lg:justify-between">
                <!-- Enhanced Search Form -->
                <form method="GET" action="{{ route('orders') }}" class="flex-1 max-w-md">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <span class="material-symbols-outlined">search</span>
                        </div>
                        <input
                            name="search"
                            value="{{ request('search') }}"
                            class="block w-full rounded-xl border-0 bg-gray-50 dark:bg-gray-800 py-3 pl-12 pr-4 text-sm text-[#121117] dark:text-white placeholder:text-gray-500 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 focus:ring-2 focus:ring-primary focus:outline-none transition-all duration-200"
                            placeholder="ID raqami yoki loyiha nomini qidirish..."
                            type="text"
                            onchange="this.form.submit()">
                        @if(request('search'))
                            <button type="button" onclick="clearSearch()"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <span class="material-symbols-outlined text-lg">close</span>
                            </button>
                        @endif
                    </div>
                </form>

                <!-- Enhanced Status Filter Tabs -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 lg:pb-0 scrollbar-hide">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400 whitespace-nowrap mr-2">Holat:</span>
                    <a href="{{ route('orders', array_merge(request()->query(), ['status' => null])) }}"
                       class="status-tab whitespace-nowrap rounded-xl {{ !request('status') || request('status') == 'all' ? 'bg-primary text-white shadow-lg' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }} px-4 py-2.5 text-sm font-semibold transition-all duration-200">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">list_alt</span>
                            Barchasi
                        </span>
                    </a>
                    <a href="{{ route('orders', array_merge(request()->query(), ['status' => 'pending'])) }}"
                       class="status-tab whitespace-nowrap rounded-xl {{ request('status') == 'pending' ? 'bg-amber-500 text-white shadow-lg' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }} px-4 py-2.5 text-sm font-semibold transition-all duration-200">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            Kutilmoqda
                        </span>
                    </a>
                    <a href="{{ route('orders', array_merge(request()->query(), ['status' => 'progress'])) }}"
                       class="status-tab whitespace-nowrap rounded-xl {{ request('status') == 'progress' ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }} px-4 py-2.5 text-sm font-semibold transition-all duration-200">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">sync</span>
                            Jarayonda
                        </span>
                    </a>
                    <a href="{{ route('orders', array_merge(request()->query(), ['status' => 'completed'])) }}"
                       class="status-tab whitespace-nowrap rounded-xl {{ request('status') == 'completed' ? 'bg-green-500 text-white shadow-lg' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }} px-4 py-2.5 text-sm font-semibold transition-all duration-200">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                            Yakunlandi
                        </span>
                    </a>
                </div>
            </div>

            @if(request('search') || request('status'))
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Faol filtrlar:</span>
                        @if(request('search'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary rounded-full">
                                <span class="material-symbols-outlined text-xs">search</span>
                                "{{ request('search') }}"
                            </span>
                        @endif
                        @if(request('status'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full">
                                <span class="material-symbols-outlined text-xs">filter_alt</span>
                                {{ ucfirst(request('status')) }}
                            </span>
                        @endif
                        <a href="{{ route('orders') }}"
                           class="inline-flex items-center gap-1 px-3 py-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                            <span class="material-symbols-outlined text-xs">close</span>
                            Tozalash
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Results Summary -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Buyurtmalar ro'yxati</h2>
            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-full text-sm font-medium">
                {{ $orders->total() }} ta buyurtma
            </span>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <span class="material-symbols-outlined text-lg">info</span>
            <span>So'nggi yangilanish: {{ now()->format('d M, H:i') }}</span>
        </div>
    </div>

    <!-- Enhanced Orders Table -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">description</span>
                            Loyiha ma'lumotlari
                        </div>
                    </th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">person</span>
                            Tarjimon
                        </div>
                    </th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">flag</span>
                            Holat
                        </div>
                    </th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">event</span>
                            Sana / Narx
                        </div>
                    </th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <span class="material-symbols-outlined text-sm">more_horiz</span>
                            Amallar
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($orders as $order)
                    @include('orders.partials.order-row', $order)
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                <div class="relative mb-6">
                                    <div class="w-20 h-20 bg-gradient-to-br from-primary/20 to-purple-600/20 rounded-full animate-pulse"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-3xl text-primary/60">assignment_late</span>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-gray-700 dark:text-gray-200 mb-2">Buyurtmalar topilmadi</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md">
                                    @if(request('search') || request('status'))
                                        Qidiruv yoki filtr bo'yicha hech qanday buyurtma topilmadi. Boshqa so'zlar bilan qidiring yoki filterlarni o'zgartiring.
                                    @else
                                        Hozircha hech qanday buyurtma yo'q. Birinchi buyurtmangizni yarating!
                                    @endif
                                </p>
                                <div class="flex gap-3">
                                    @if(request('search') || request('status'))
                                        <a href="{{ route('orders') }}"
                                           class="px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                            Barchasini ko'rish
                                        </a>
                                    @endif
                                    <a href="{{ route('orders.create') }}"
                                       class="px-6 py-2 bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors font-medium">
                                        Yangi buyurtma
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @include('orders.partials.table-pagination')
    </div>

    @push('scripts')
    <script>
    function clearSearch() {
        const searchInput = document.querySelector('input[name="search"]');
        searchInput.value = '';
        searchInput.form.submit();
    }

    // Status tab animations
    document.addEventListener('DOMContentLoaded', function() {
        const statusTabs = document.querySelectorAll('.status-tab');
        statusTabs.forEach(tab => {
            tab.addEventListener('mouseenter', function() {
                if (!this.classList.contains('bg-primary') &&
                    !this.classList.contains('bg-amber-500') &&
                    !this.classList.contains('bg-blue-500') &&
                    !this.classList.contains('bg-green-500')) {
                    this.style.transform = 'translateY(-1px)';
                }
            });

            tab.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Search input enhancements
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.style.transform = 'scale(1.02)';
            });

            searchInput.addEventListener('blur', function() {
                this.style.transform = 'scale(1)';
            });
        }
    });
    </script>
    @endpush

    @push('styles')
    <style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .status-tab:hover {
        transform: translateY(-1px);
    }

    input:focus, select:focus {
        transition: transform 0.2s ease;
    }

    /* Dropdown menu animations */
    .dropdown-menu {
        backdrop-filter: blur(8px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .dropdown-menu.opacity-100 {
        animation: dropdownFadeIn 0.2s ease-out;
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-5px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Notification animations */
    .notification {
        animation: slideInFromRight 0.3s ease-out;
    }

    @keyframes slideInFromRight {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(0);
        }
    }

    /* Action button hover effects */
    .group\/item:hover {
        transform: translateX(2px);
    }

    /* Dropdown toggle focus styles */
    .dropdown-toggle:focus {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Status badges with improved animations */
    .animate-pulse-slow {
        animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .7;
        }
    }
    </style>
    @endpush
@endsection
