{{-- Live Rating Stats --}}
<div class="flex items-center text-yellow-500">
    <span class="material-symbols-outlined text-lg star-filled">star</span>
    <span class="font-semibold ml-1">{{ number_format($averageRating, 1) }}</span>
    <span class="text-xs text-gray-500 ml-1">({{ $totalReviews }} sharh)</span>
</div>
