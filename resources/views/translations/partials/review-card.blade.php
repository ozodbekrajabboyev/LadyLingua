@props(['initials', 'name', 'time', 'rating', 'color', 'text'])

@php
    $colorClasses = [
        'blue' => 'bg-blue-100 text-blue-600',
        'green' => 'bg-green-100 text-green-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'pink' => 'bg-pink-100 text-pink-600',
        'yellow' => 'bg-yellow-100 text-yellow-600',
        'red' => 'bg-red-100 text-red-600',
    ];

    $avatarColor = $colorClasses[$color] ?? 'bg-gray-100 text-gray-600';
@endphp

<div class="bg-white dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800">
    <div class="flex justify-between items-start mb-2">
        {{-- User Info --}}
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-sm">
                {{ $initials }}
            </div>
            <div>
                <p class="font-bold text-sm text-[#121117] dark:text-white">{{ $name }}</p>
                <p class="text-xs text-gray-400">{{ $time }}</p>
            </div>
        </div>

        {{-- Rating Stars --}}
        <div class="flex text-yellow-500 text-sm">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $rating)
                    <span class="material-symbols-outlined filled-icon text-[18px]">star</span>
                @else
                    <span class="material-symbols-outlined text-[18px]">star</span>
                @endif
            @endfor
        </div>
    </div>

    {{-- Review Text --}}
    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
        {{ $text }}
    </p>
</div>
