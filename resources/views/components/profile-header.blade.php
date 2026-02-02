@props([
    'name' => 'Alex Chen',
    'title' => 'Certified Japanese Translator | 10+ Years Experience',
    'rating' => '5.0',
    'reviews' => '120',
    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuANn8fk5q6ABIho239dGM7s-epjKrdh0Y3Y6aarvqLoDTUA_HkduhYGBNqtSPqzSumcnjxI__MG_8TOizKKAmiEPCw1jskFv1CWW2j1QjWJ4jdbA6xtWg-zLe0pkfWuloXMXC7D-84IPz8z14eyr4u_LolxRsPWmD8A9XtnGT1LHbgz0nlAFAvOY0fk64T6M60NyvvdMkpb_ZNT4HBHO24TQnaS9UBhx2IQaC0BBggvsFx0L3CxjiLnO9R2n-PxjuUQtOHkNlfcTa4'
])

<div class="mb-8 p-6 bg-white dark:bg-[#1a192a] rounded-xl border border-[#e5e7eb] dark:border-[#2a2a3a] shadow-sm">
    <div class="flex flex-col @container lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="flex gap-6 items-center">
            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-xl min-h-24 w-24 border-2 border-primary/10 shadow-lg" style='background-image: url("{{ $avatar }}");'></div>
            <div class="flex flex-col">
                <div class="flex items-center gap-2">
                    <p class="text-[#121117] dark:text-white text-[24px] font-bold leading-tight tracking-[-0.015em]">{{ $name }}</p>
                    <span class="material-symbols-outlined text-blue-500 text-xl" title="Verified Professional">verified</span>
                </div>
                <p class="text-[#656487] dark:text-gray-400 text-base font-medium">{{ $title }}</p>
                <div class="flex items-center gap-1 mt-1 text-orange-400">
                    @for($i = 0; $i < 5; $i++)
                        <span class="material-symbols-outlined text-sm fill-current">star</span>
                    @endfor
                    <p class="text-[#121117] dark:text-gray-300 text-sm font-bold ml-1">{{ $rating }}</p>
                    <p class="text-[#656487] dark:text-gray-400 text-sm ml-1">({{ $reviews }} reviews)</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <button class="flex min-w-[120px] cursor-pointer items-center justify-center rounded-lg h-11 px-6 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all shadow-md shadow-primary/20">
                <span class="truncate">Submit Proposal</span>
            </button>
        </div>
    </div>
</div>
