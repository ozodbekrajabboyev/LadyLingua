@props([
    'title' => 'Translation Title',
    'description' => 'Translation description',
    'languageFrom' => 'EN',
    'languageTo' => 'UZ',
    'rating' => '4.9',
    'translatorName' => 'Translator Name',
    'translatorImage' => '',
    'timeAgo' => 'Recently',
    'icon' => 'description'
])

<div class="group bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1 transition-all flex flex-col h-full">
    <div class="flex justify-between items-start mb-6">
        <div class="h-12 w-12 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-3xl">{{ $icon }}</span>
        </div>
        <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded-full uppercase tracking-widest">
            {{ $languageFrom }} → {{ $languageTo }}
        </span>
    </div>
    <div class="flex-1">
        <div class="flex justify-between items-start mb-2">
            <h4 class="text-lg font-bold text-[#121117] dark:text-white group-hover:text-primary transition-colors">
                {{ $title }}
            </h4>
            <div class="flex items-center bg-gray-50 dark:bg-gray-800 px-2 py-0.5 rounded-lg">
                <span class="material-symbols-outlined text-[14px] star-filled">star</span>
                <span class="ml-1 text-xs font-bold">{{ $rating }}</span>
            </div>
        </div>
        <p class="text-gray-500 text-sm mb-6 line-clamp-2">{{ $description }}</p>
    </div>
    <div class="flex items-center justify-between pt-4 border-t border-gray-50 dark:border-gray-800">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-gray-100 overflow-hidden">
                <img alt="Translator" class="w-full h-full object-cover" src="{{ $translatorImage }}">
            </div>
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $translatorName }}</span>
        </div>
        <span class="text-xs text-gray-400">{{ $timeAgo }}</span>
    </div>
</div>
