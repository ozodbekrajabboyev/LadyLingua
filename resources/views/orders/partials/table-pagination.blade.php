@if($orders->hasPages())
<div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 px-6 py-4">
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Showing
                <span class="font-medium text-[#121117] dark:text-white">{{ $orders->firstItem() ?? 0 }}</span>
                to
                <span class="font-medium text-[#121117] dark:text-white">{{ $orders->lastItem() ?? 0 }}</span>
                of <span class="font-medium text-[#121117] dark:text-white">{{ $orders->total() }}</span> results
            </p>
        </div>
        <div>
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
    <div class="flex flex-1 justify-between sm:hidden">
        @if($orders->previousPageUrl())
            <a href="{{ $orders->appends(request()->query())->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
        @else
            <span class="relative inline-flex items-center rounded-md border border-gray-200 bg-gray-100 px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">Previous</span>
        @endif

        @if($orders->nextPageUrl())
            <a href="{{ $orders->appends(request()->query())->nextPageUrl() }}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        @else
            <span class="relative ml-3 inline-flex items-center rounded-md border border-gray-200 bg-gray-100 px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">Next</span>
        @endif
    </div>
</div>
@endif

<!-- Always show total count -->
@if(!$orders->hasPages() && $orders->total() > 0)
<div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Total <span class="font-medium text-[#121117] dark:text-white">{{ $orders->total() }}</span> results
    </p>
</div>
@endif
