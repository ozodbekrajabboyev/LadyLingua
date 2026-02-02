@props(['color' => 'default'])

@php
    $colorClasses = [
        'primary' => 'bg-primary/10 text-primary border-primary/20',
        'default' => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700',
        'blue' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-800',
        'green' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 border-green-200 dark:border-green-800',
        'purple' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 border-purple-200 dark:border-purple-800',
        'orange' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 border-orange-200 dark:border-orange-800',
    ];

    $classes = $colorClasses[$color] ?? $colorClasses['default'];
@endphp

<span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium border {{ $classes }}">
    {{ $slot }}
</span>
