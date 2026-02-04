{{-- Translator Profile Header --}}
<section class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl p-8">
    <div class="flex flex-col sm:flex-row gap-6">
        {{-- Profile Image --}}
        <div class="flex-shrink-0">
            <div class="size-32 rounded-xl bg-gray-100 overflow-hidden ring-1 ring-gray-200 relative">
                <img alt="{{ $translator['name'] }}"
                     class="h-full w-full object-cover"
                     src="{{ $translator['avatar'] }}"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold"
                     style="display:none;">
                    {{ strtoupper(substr($translator['name'], 0, 2)) }}
                </div>
            </div>
        </div>

        {{-- Profile Info --}}
        <div class="flex-1 min-w-0">
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-[#121117] dark:text-white mb-2">{{ $translator['name'] }}</h1>

                <div class="flex items-center gap-4 mb-3">
                    <div class="flex items-center text-yellow-500">
                        <span class="material-symbols-outlined text-[20px] star-filled">star</span>
                        <span class="text-lg font-semibold ml-1">{{ $translator['rating'] }}</span>
                    </div>
                    <span class="text-sm text-gray-500">({{ $translator['reviews'] }} sharhlar)</span>
                    <span class="text-sm text-gray-500">{{ $translator['member_since'] }}</span>
                </div>

                {{-- Languages --}}
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    @foreach($translator['languages'] as $lang)
                        <span class="inline-flex items-center rounded-md bg-indigo-50 px-3 py-1 text-sm font-semibold text-primary ring-1 ring-inset ring-indigo-700/10 dark:bg-indigo-900/30">{{ $lang }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Bio --}}
            <div class="text-gray-600 dark:text-gray-400 leading-relaxed">
                {!! $translator['bio'] !!}
            </div>
        </div>
    </div>
</section>
