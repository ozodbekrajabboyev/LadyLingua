{{-- Statistics Section - Database Data Only --}}
<section class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl p-6">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-primary">analytics</span>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Statistika</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Asosiy ko'rsatkichlar</p>
        </div>
    </div>

    <!-- Main Stats Grid - Real Database Data Only -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Completed Projects --}}
        <div class="bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 rounded-xl p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-xl">task_alt</span>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $translator['completed_projects'] }}</div>
                </div>
            </div>
            <div class="text-sm font-medium text-green-800 dark:text-green-200">Bajarilgan loyiha</div>
        </div>

        {{-- Total Reviews --}}
        <div class="bg-gradient-to-br from-yellow-50 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 rounded-xl p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-xl">star</span>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-yellow-700 dark:text-yellow-300">{{ $translator['reviews'] }}</div>
                </div>
            </div>
            <div class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Jami sharh</div>
        </div>

        {{-- Average Rating --}}
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-xl p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-xl">trending_up</span>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $translator['rating'] }}</div>
                </div>
            </div>
            <div class="text-sm font-medium text-blue-800 dark:text-blue-200">O'rtacha reyting</div>
        </div>
    </div>
</section>
