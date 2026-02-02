@props([
    'pageNumber' => 1,
    'title' => '',
    'content' => '',
    'price' => '15,000',
    'currency' => 'UZS'
])

<div class="w-[210mm] min-h-[297mm] bg-white shadow-lg relative shrink-0 overflow-hidden" data-page="{{ $pageNumber }}">
    <div class="p-12 text-justify flex flex-col relative z-0">
        {{-- Page Header --}}
        <div class="text-xs text-gray-400 mb-8 flex justify-between">
            <span>{{ $title }}</span>
            <span>{{ $pageNumber }}-sahifa</span>
        </div>

        {{-- Page Content with Progressive Blur --}}
        <div class="space-y-4 text-gray-800 text-sm leading-relaxed font-serif">
            @if(is_array($content))
                {{-- First paragraph - clear --}}
                @if(isset($content[0]))
                    <p>{{ $content[0] }}</p>
                @endif

                {{-- Second paragraph - slight blur --}}
                @if(isset($content[1]))
                    <p class="blur-[1px]">{{ $content[1] }}</p>
                @endif

                {{-- Third paragraph - more blur --}}
                @if(isset($content[2]))
                    <p class="blur-[2px]">{{ $content[2] }}</p>
                @endif
            @elseif(is_string($content))
                {{-- If content is a single string, split it --}}
                <div class="blur-[1px]">{!! Str::limit($content, 300) !!}</div>
            @endif

            {{-- Placeholder Lines (heavily blurred) --}}
            <div class="space-y-4 blur-sm opacity-60 mt-4">
                <div class="h-2 bg-gray-800 rounded w-full"></div>
                <div class="h-2 bg-gray-800 rounded w-11/12"></div>
                <div class="h-2 bg-gray-800 rounded w-full"></div>
                <div class="h-2 bg-gray-800 rounded w-4/5"></div>
                <div class="h-2 bg-gray-800 rounded w-full"></div>
                <div class="h-2 bg-gray-800 rounded w-full"></div>
                <div class="h-2 bg-gray-800 rounded w-3/4"></div>
            </div>
            <div class="space-y-4 blur-md opacity-40 mt-4">
                <div class="h-2 bg-gray-800 rounded w-full"></div>
                <div class="h-2 bg-gray-800 rounded w-11/12"></div>
                <div class="h-2 bg-gray-800 rounded w-full"></div>
            </div>
        </div>
    </div>

    {{-- Overlay Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/60 to-white/95 z-10"></div>

    {{-- Purchase Modal --}}
    <div class="absolute inset-0 flex items-center justify-center z-20 p-4">
        @include('translations.partials.purchase-modal', [
            'price' => $price,
            'currency' => $currency
        ])
    </div>
</div>
