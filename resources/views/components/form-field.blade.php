@props(['label', 'icon' => null])

<div class="flex flex-col gap-1.5 flex-1">
    <label class="text-[#121117] dark:text-gray-200 text-sm font-semibold leading-normal">{{ $label }}</label>
    <div class="relative">
        {{ $slot }}
        @if($icon)
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-[#656487] pointer-events-none">
                {{ $icon }}
            </span>
        @endif
    </div>
</div>
