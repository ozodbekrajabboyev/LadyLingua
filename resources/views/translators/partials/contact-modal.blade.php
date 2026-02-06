{{-- Contact Modal --}}
<div id="contact-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                    <img alt="{{ $translator['name'] }}" src="{{ $translator['avatar'] }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $translator['name'] }}ga xabar yuborish</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Professional Translator</p>
                </div>
            </div>
            <button class="close-modal w-10 h-10 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-gray-500">close</span>
            </button>
        </div>

        <!-- Modal Content -->
        <div class="p-6">
            <form id="contact-form" class="space-y-6">
                <!-- Project Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Loyiha turi</label>
                    <select class="w-full rounded-xl border border-gray-200 dark:border-gray-600 px-4 py-3 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-primary transition-all">
                        <option value="">Loyiha turini tanlang</option>
                        <option value="document">Hujjat tarjimasi</option>
                        <option value="website">Veb-sayt tarjimasi</option>
                        <option value="book">Kitob tarjimasi</option>
                        <option value="legal">Huquqiy hujjatlar</option>
                        <option value="medical">Tibbiy matnlar</option>
                        <option value="technical">Texnik hujjatlar</option>
                        <option value="other">Boshqa</option>
                    </select>
                </div>

                <!-- Language Pair -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Qaysi tildan</label>
                        <select class="w-full rounded-xl border border-gray-200 dark:border-gray-600 px-4 py-3 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-primary transition-all">
                            <option value="">Tanlang</option>
                            @foreach($translator['languages'] as $lang)
                                <option value="{{ strtolower($lang) }}">{{ $lang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Qaysi tilga</label>
                        <select class="w-full rounded-xl border border-gray-200 dark:border-gray-600 px-4 py-3 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-primary transition-all">
                            <option value="">Tanlang</option>
                            @foreach($translator['languages'] as $lang)
                                <option value="{{ strtolower($lang) }}">{{ $lang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Word Count -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Taxminiy so'zlar soni</label>
                    <input type="number" placeholder="Masalan: 1000" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 px-4 py-3 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-primary transition-all">
                </div>

                <!-- Deadline -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tugallash muddati</label>
                    <input type="date" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 px-4 py-3 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-primary transition-all">
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Xabar</label>
                    <textarea rows="5" placeholder="Loyihangiz haqida batafsil ma'lumot bering..." class="w-full rounded-xl border border-gray-200 dark:border-gray-600 px-4 py-3 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-primary transition-all"></textarea>
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fayllarni biriktirish</label>
                    <div class="border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl p-6 text-center">
                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <span class="material-symbols-outlined text-gray-400">upload_file</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Fayllarni shu yerga tashlang yoki</p>
                        <button type="button" class="text-primary hover:text-primary/80 font-medium">fayl tanlang</button>
                        <p class="text-xs text-gray-500 mt-2">PDF, DOC, DOCX (maks. 10MB)</p>
                    </div>
                </div>

                <!-- Budget -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Byudjet</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" placeholder="Minimal narx" class="rounded-xl border border-gray-200 dark:border-gray-600 px-4 py-3 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-primary transition-all">
                        <input type="number" placeholder="Maksimal narx" class="rounded-xl border border-gray-200 dark:border-gray-600 px-4 py-3 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-primary transition-all">
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-between p-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-lg text-green-500">security</span>
                Xavfsiz va himoyalangan aloqa
            </div>
            <div class="flex items-center gap-3">
                <button class="close-modal px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors">
                    Bekor qilish
                </button>
                <button type="submit" form="contact-form" class="px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-xl font-semibold transition-all duration-200">
                    Xabar yuborish
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle contact form submission
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        e.preventDefault();

        // Show success message
        const modal = document.getElementById('contact-modal');
        modal.innerHTML = `
            <div class="bg-white dark:bg-gray-900 rounded-2xl max-w-md w-full p-8 text-center">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-green-500 text-2xl">check_circle</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Xabar yuborildi!</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $translator['name'] }} tez orada siz bilan bog'lanadi.</p>
                <button class="close-modal w-full px-6 py-3 bg-primary text-white rounded-xl font-semibold">
                    Yopish
                </button>
            </div>
        `;

        // Re-bind close event
        modal.querySelector('.close-modal').addEventListener('click', function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        });

        // Auto close after 3 seconds
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }, 3000);
    });
});
</script>
