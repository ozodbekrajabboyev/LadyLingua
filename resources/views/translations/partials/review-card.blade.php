{{-- Dynamic review card component --}}
@php
    $colorClasses = [
        'blue' => 'bg-blue-100 text-blue-600',
        'green' => 'bg-green-100 text-green-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'pink' => 'bg-pink-100 text-pink-600',
        'yellow' => 'bg-yellow-100 text-yellow-600',
        'red' => 'bg-red-100 text-red-600',
    ];

    $colors = array_keys($colorClasses);
    $selectedColor = $colors[crc32($review['user_name']) % count($colors)];
    $avatarColor = $colorClasses[$selectedColor];
    $initials = strtoupper(substr($review['user_name'], 0, 2));
@endphp

<div class="bg-white dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800">
    <div class="flex justify-between items-start mb-2">
        {{-- User Info --}}
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-sm">
                {{ $initials }}
            </div>
            <div>
                <p class="font-bold text-sm text-[#121117] dark:text-white">{{ $review['user_name'] }}</p>
                <p class="text-xs text-gray-400">{{ $review['date'] }}</p>
            </div>
        </div>

        {{-- Rating Stars --}}
        <div class="flex text-yellow-500 text-sm">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $review['rating'])
                    <span class="material-symbols-outlined filled-icon text-[18px]">star</span>
                @else
                    <span class="material-symbols-outlined text-[18px]">star</span>
                @endif
            @endfor
        </div>
    </div>

    {{-- Review Text --}}
    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
        {{ $review['comment'] ?: 'Ajoyib tarjima! Tavsiya qilaman.' }}
    </p>
</div>
