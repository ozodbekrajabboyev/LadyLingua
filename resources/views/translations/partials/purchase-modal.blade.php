@props([
    'price' => '15,000',
    'currency' => 'UZS',
    'bookId' => null
])

<div class="bg-white dark:bg-surface-dark rounded-2xl shadow-2xl p-8 max-w-md w-full text-center border border-gray-100 dark:border-gray-700 transform transition-transform hover:scale-105 duration-300">
    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6 text-primary">
        <span class="material-symbols-outlined text-3xl">lock</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
        Davomini o'qishni xohlaysizmi?
    </h2>
    <p class="text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
        Ushbu tarjimani to'liq o'qish uchun sotib oling. To'lovdan so'ng to'liq hujjat avtomatik ravishda ochiladi.
    </p>
    <button
        onclick="purchaseBook({{ $bookId ?? 'null' }})"
        class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-primary/30 transition-all flex items-center justify-center gap-2 group">
        <span>Sotib Olish</span>
        <span class="bg-white/20 px-2 py-0.5 rounded text-sm group-hover:bg-white/30 transition">
            {{ number_format((float)str_replace(',', '', $price)) }} {{ $currency }}
        </span>
    </button>
    <p class="mt-4 text-xs text-gray-400">
        Xavfsiz to'lov • PDF yuklab olish imkoniyati
    </p>
</div>

@push('scripts')
    <script>
        function purchaseBook(bookId) {
            if (!bookId) {
                console.error('Book ID not provided');
                return;
            }
            // Redirect to purchase/checkout page
            window.location.href = `/purchase/${bookId}`;
        }
    </script>
@endpush
