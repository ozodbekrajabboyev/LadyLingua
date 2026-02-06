{{-- Translator Profile Header - Database Data Only --}}
<section class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl p-8">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Profile Image --}}
        <div class="flex-shrink-0">
            <div class="size-32 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 overflow-hidden ring-2 ring-gray-200 dark:ring-gray-600 relative">
                <img alt="{{ $translator['name'] }}"
                     class="h-full w-full object-cover"
                     src="{{ $translator['avatar'] }}"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="absolute inset-0 bg-gradient-to-br from-primary to-purple-600 flex items-center justify-center text-white text-2xl font-bold"
                     style="display:none;">
                    {{ strtoupper(substr($translator['name'], 0, 2)) }}
                </div>
            </div>
        </div>

        {{-- Profile Info --}}
        <div class="flex-1 min-w-0 space-y-6">
            <!-- Name and Title -->
            <div class="space-y-3">
                <h1 class="text-3xl font-bold text-[#121117] dark:text-white">{{ $translator['name'] }}</h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">Professional Translator</p>
            </div>

            <!-- Rating and Stats - Real Database Data -->
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="material-symbols-outlined text-yellow-400 {{ $i <= floor($translator['rating']) ? 'star-filled' : '' }} text-xl">
                                {{ $i <= floor($translator['rating']) ? 'star' : ($i <= ceil($translator['rating']) ? 'star_half' : 'star_border') }}
                            </span>
                        @endfor
                    </div>
                    <span class="text-2xl font-bold text-[#121117] dark:text-white">{{ $translator['rating'] }}</span>
                    <span class="text-gray-500 dark:text-gray-400">({{ $translator['reviews'] }} sharh)</span>
                </div>

                <div class="h-6 w-px bg-gray-200 dark:bg-gray-700"></div>

                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined text-lg">calendar_today</span>
                    <span>{{ $translator['member_since'] }}dan beri faol</span>
                </div>
            </div>

            <!-- Languages - Real Database Data -->
            <div class="space-y-3">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Tillari</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($translator['languages'] as $lang)
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-primary/10 to-purple-600/10 text-primary border border-primary/20 font-semibold">
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                            {{ $lang }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Bio - Real Database Data -->
            <div class="space-y-3">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Haqida</h3>
                <div class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {!! $translator['bio'] !!}
                </div>
            </div>

            <!-- Quick Stats Row - Real Database Data Only -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary">{{ $translator['completed_projects'] }}</div>
                    <div class="text-sm text-gray-500">Loyiha</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary">{{ $translator['reviews'] }}</div>
                    <div class="text-sm text-gray-500">Sharh</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary">{{ count($translator['languages']) }}</div>
                    <div class="text-sm text-gray-500">Til</div>
                </div>
            </div>
        </div>
    </div>
</section>
