{{-- Statistics Section --}}
<section class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl p-6">
    <h2 class="text-lg font-bold text-[#121117] dark:text-white mb-4">Statistika</h2>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        {{-- Completed Projects --}}
        <div class="text-center">
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-lg p-4 mb-2">
                <span class="material-symbols-outlined text-green-600 text-3xl">task_alt</span>
            </div>
            <div class="text-2xl font-bold text-[#121117] dark:text-white">{{ $translator['completed_projects'] }}</div>
            <div class="text-sm text-gray-500">Bajarilgan loyiha</div>
        </div>

        {{-- Total Reviews --}}
        <div class="text-center">
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/30 dark:to-yellow-800/30 rounded-lg p-4 mb-2">
                <span class="material-symbols-outlined text-yellow-600 text-3xl">star</span>
            </div>
            <div class="text-2xl font-bold text-[#121117] dark:text-white">{{ $translator['reviews'] }}</div>
            <div class="text-sm text-gray-500">Jami sharh</div>
        </div>

        {{-- Average Rating --}}
        <div class="text-center">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-lg p-4 mb-2">
                <span class="material-symbols-outlined text-blue-600 text-3xl">trending_up</span>
            </div>
            <div class="text-2xl font-bold text-[#121117] dark:text-white">{{ $translator['rating'] }}</div>
            <div class="text-sm text-gray-500">O'rtacha reyting</div>
        </div>
    </div>
</section>
