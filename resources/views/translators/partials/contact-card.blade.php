{{-- Contact Card Component --}}
<div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 sticky top-8">
    <!-- Contact Header -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-primary">contact_mail</span>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aloqa</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Loyiha haqida gaplashing</p>
        </div>
    </div>

    <!-- Response Time -->
    <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl p-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-sm">schedule</span>
            </div>
            <div>
                <div class="text-sm font-semibold text-green-800 dark:text-green-200">Tez javob beradi</div>
                <div class="text-xs text-green-600 dark:text-green-400">Odatda 2 soat ichida javob beradi</div>
            </div>
        </div>
    </div>

    <!-- Contact Actions -->
    <div class="space-y-3">
        <button class="contact-btn w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-primary hover:bg-primary/90 text-white rounded-xl font-semibold transition-all duration-200 hover:shadow-lg hover:shadow-primary/25">
            <span class="material-symbols-outlined">chat</span>
            Xabar yuborish
        </button>

        <button class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold transition-all duration-200">
            <span class="material-symbols-outlined">videocam</span>
            Video qo'ng'iroq
        </button>

        <a href="mailto:{{ $translator['email'] }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl font-semibold transition-all duration-200">
            <span class="material-symbols-outlined">email</span>
            Email yuborish
        </a>
    </div>

    <!-- Contact Info -->
    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-3">
        <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
            <span class="material-symbols-outlined text-lg">schedule</span>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Ish vaqti</div>
                <div>Dush-Jum 9:00-18:00 (UTC+5)</div>
            </div>
        </div>

        <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
            <span class="material-symbols-outlined text-lg">location_on</span>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Joylashuv</div>
                <div>Toshkent, O'zbekiston</div>
            </div>
        </div>

        <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
            <span class="material-symbols-outlined text-lg">payments</span>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Narx</div>
                <div>1000 so'm/so'z dan</div>
            </div>
        </div>
    </div>

    <!-- Trust Indicators -->
    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mx-auto mb-2">
                    <span class="material-symbols-outlined text-blue-600">verified_user</span>
                </div>
                <div class="text-xs font-medium text-gray-900 dark:text-white">ID Tasdiqlangan</div>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mx-auto mb-2">
                    <span class="material-symbols-outlined text-green-600">payment</span>
                </div>
                <div class="text-xs font-medium text-gray-900 dark:text-white">To'lov himoyalangan</div>
            </div>
        </div>
    </div>
</div>
