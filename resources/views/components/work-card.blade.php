@props(['image', 'category', 'title', 'description', 'wordCount'])

<div class="group flex flex-col bg-white dark:bg-[#1a192a] rounded-xl border border-[#e5e7eb] dark:border-[#2a2a3a] overflow-hidden hover:shadow-lg transition-all">
    <div class="h-40 w-full bg-cover bg-center" style="background-image: url('{{ $image }}');">
        <div class="w-full h-full bg-black/20 group-hover:bg-black/10 transition-colors flex items-end p-4">
            <span class="bg-white/90 dark:bg-black/70 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-tight">{{ $category }}</span>
        </div>
    </div>
    <div class="p-5">
        <h4 class="text-[#121117] dark:text-white font-bold mb-2">{{ $title }}</h4>
        <p class="text-[#656487] dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ $description }}</p>
        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
            <span class="text-xs font-medium text-[#656487] dark:text-gray-400">{{ $wordCount }} words</span>
            <span class="text-xs font-bold text-primary cursor-pointer">View Details</span>
        </div>
    </div>
</div>
