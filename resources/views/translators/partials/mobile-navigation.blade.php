<!-- Enhanced Mobile Navigation for Translators Page -->
<div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-40">
    <div class="flex items-center justify-around py-2">
        <!-- Search Toggle -->
        <button id="mobile-search-toggle" class="flex flex-col items-center py-2 px-4 text-gray-500 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-xl">search</span>
            <span class="text-xs mt-1">Qidiruv</span>
        </button>

        <!-- Filter Toggle -->
        <button id="mobile-filter-toggle" class="flex flex-col items-center py-2 px-4 text-gray-500 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-xl">tune</span>
            <span class="text-xs mt-1">Filtrlar</span>
        </button>

        <!-- Sort Toggle -->
        <button id="mobile-sort-toggle" class="flex flex-col items-center py-2 px-4 text-gray-500 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-xl">sort</span>
            <span class="text-xs mt-1">Saralash</span>
        </button>

        <!-- View Toggle -->
        <button id="mobile-view-toggle" class="flex flex-col items-center py-2 px-4 text-gray-500 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-xl">view_list</span>
            <span class="text-xs mt-1">Ko'rinish</span>
        </button>

        <!-- Map View (Future feature) -->
        <button class="flex flex-col items-center py-2 px-4 text-gray-400 opacity-50">
            <span class="material-symbols-outlined text-xl">map</span>
            <span class="text-xs mt-1">Xarita</span>
        </button>
    </div>
</div>

<!-- Mobile Search Overlay -->
<div id="mobile-search-overlay" class="lg:hidden fixed inset-0 bg-white dark:bg-gray-900 z-50 transform translate-y-full transition-transform duration-300">
    <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Qidiruv</h3>
        <button class="close-mobile-overlay text-gray-500 hover:text-gray-700">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    <div class="p-4">
        <div class="relative mb-4">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-gray-400">search</span>
            </div>
            <input type="text" id="mobile-search-input" class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Tarjimon nomi, til yoki sohasi...">
        </div>
        <div class="space-y-3">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Oxirgi qidiruvlar</h4>
            <div class="flex flex-wrap gap-2">
                <button class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-sm">English tarjimon</button>
                <button class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-sm">Yuqori reyting</button>
                <button class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-sm">Tibbiy matn</button>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Filter Overlay -->
<div id="mobile-filter-overlay" class="lg:hidden fixed inset-0 bg-white dark:bg-gray-900 z-50 transform translate-y-full transition-transform duration-300">
    <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filtrlar</h3>
        <button class="close-mobile-overlay text-gray-500 hover:text-gray-700">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    <div class="p-4 space-y-6">
        <!-- Language Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Til</label>
            <select class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-3 py-3 bg-white dark:bg-gray-800 dark:text-white">
                <option value="">Barcha tillar</option>
                @if($availableLanguages->isNotEmpty())
                    @foreach($availableLanguages as $language)
                        <option value="{{ $language->lang_name }}" {{ request('language') == $language->lang_name ? 'selected' : '' }}>
                            {{ $language->lang_name }}
                        </option>
                    @endforeach
                @else
                    <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
                    <option value="O'zbekcha" {{ request('language') == "O'zbekcha" ? 'selected' : '' }}>O'zbekcha</option>
                    <option value="Русский" {{ request('language') == 'Русский' ? 'selected' : '' }}>Русский</option>
                    <option value="Español" {{ request('language') == 'Español' ? 'selected' : '' }}>Español</option>
                    <option value="Français" {{ request('language') == 'Français' ? 'selected' : '' }}>Français</option>
                @endif
            </select>
        </div>

        <!-- Rating Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimal reyting</label>
            <div class="flex items-center space-x-2">
                <div class="flex-1">
                    <input type="range" min="1" max="5" step="0.5" value="3" class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 w-12">3.0+</span>
            </div>
            <div class="flex items-center justify-between text-xs text-gray-500 mt-1">
                <span>1</span>
                <span>5</span>
            </div>
        </div>

        <!-- Experience Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Tajriba darajasi</label>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="mobile-experience" value="all" class="text-primary focus:ring-primary" checked>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Barcha darajalar</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="mobile-experience" value="beginner" class="text-primary focus:ring-primary">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Yangi (0-1 yil)</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="mobile-experience" value="intermediate" class="text-primary focus:ring-primary">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">O'rtacha (2-5 yil)</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="mobile-experience" value="expert" class="text-primary focus:ring-primary">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Mutaxassis (5+ yil)</span>
                </label>
            </div>
        </div>

        <!-- Availability Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Mavjudlik</label>
            <div class="grid grid-cols-2 gap-2">
                <button class="availability-filter-btn px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:border-primary hover:text-primary transition-all" data-value="all">
                    <span class="material-symbols-outlined text-sm mb-1 block">schedule</span>
                    Barchasi
                </button>
                <button class="availability-filter-btn px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:border-primary hover:text-primary transition-all" data-value="online">
                    <span class="material-symbols-outlined text-sm mb-1 block text-green-500">circle</span>
                    Onlayn
                </button>
                <button class="availability-filter-btn px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:border-primary hover:text-primary transition-all" data-value="today">
                    <span class="material-symbols-outlined text-sm mb-1 block">today</span>
                    Bugun
                </button>
                <button class="availability-filter-btn px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:border-primary hover:text-primary transition-all" data-value="week">
                    <span class="material-symbols-outlined text-sm mb-1 block">calendar_week</span>
                    Shu hafta
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Actions -->
    <div class="absolute bottom-0 left-0 right-0 p-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="flex gap-3">
            <a href="{{ route('translators') }}" class="flex-1 px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-medium text-center">
                Tozalash
            </a>
            <button onclick="applyMobileFilters()" class="flex-1 px-4 py-3 bg-primary text-white rounded-xl font-medium">
                Qo'llash
            </button>
        </div>
    </div>
</div>

<!-- Mobile Sort Overlay -->
<div id="mobile-sort-overlay" class="lg:hidden fixed inset-0 bg-white dark:bg-gray-900 z-50 transform translate-y-full transition-transform duration-300">
    <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Saralash</h3>
        <button class="close-mobile-overlay text-gray-500 hover:text-gray-700">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    <div class="p-4">
        <div class="space-y-3">
            <button class="sort-option w-full flex items-center justify-between p-4 border border-gray-200 dark:border-gray-600 rounded-xl text-left hover:border-primary transition-colors" data-sort="rating">
                <div class="flex items-center">
                    <span class="material-symbols-outlined mr-3 text-primary">star</span>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">Reyting bo'yicha</div>
                        <div class="text-sm text-gray-500">Eng yuqoridan pastga</div>
                    </div>
                </div>
                <div class="check-icon hidden">
                    <span class="material-symbols-outlined text-primary">check</span>
                </div>
            </button>

            <button class="sort-option w-full flex items-center justify-between p-4 border border-gray-200 dark:border-gray-600 rounded-xl text-left hover:border-primary transition-colors" data-sort="name">
                <div class="flex items-center">
                    <span class="material-symbols-outlined mr-3 text-gray-400">sort_by_alpha</span>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">Ism bo'yicha</div>
                        <div class="text-sm text-gray-500">Alfabet tartibida</div>
                    </div>
                </div>
                <div class="check-icon hidden">
                    <span class="material-symbols-outlined text-primary">check</span>
                </div>
            </button>

            <button class="sort-option w-full flex items-center justify-between p-4 border border-gray-200 dark:border-gray-600 rounded-xl text-left hover:border-primary transition-colors" data-sort="reviews">
                <div class="flex items-center">
                    <span class="material-symbols-outlined mr-3 text-gray-400">reviews</span>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">Sharhlar soni</div>
                        <div class="text-sm text-gray-500">Ko'pdan kamga</div>
                    </div>
                </div>
                <div class="check-icon hidden">
                    <span class="material-symbols-outlined text-primary">check</span>
                </div>
            </button>

            <button class="sort-option w-full flex items-center justify-between p-4 border border-gray-200 dark:border-gray-600 rounded-xl text-left hover:border-primary transition-colors" data-sort="recent">
                <div class="flex items-center">
                    <span class="material-symbols-outlined mr-3 text-gray-400">schedule</span>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">Yangi qo'shilganlar</div>
                        <div class="text-sm text-gray-500">So'nggi faollik</div>
                    </div>
                </div>
                <div class="check-icon hidden">
                    <span class="material-symbols-outlined text-primary">check</span>
                </div>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation Handlers
    const mobileSearchToggle = document.getElementById('mobile-search-toggle');
    const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
    const mobileSortToggle = document.getElementById('mobile-sort-toggle');
    const mobileViewToggle = document.getElementById('mobile-view-toggle');

    const mobileSearchOverlay = document.getElementById('mobile-search-overlay');
    const mobileFilterOverlay = document.getElementById('mobile-filter-overlay');
    const mobileSortOverlay = document.getElementById('mobile-sort-overlay');

    const closeButtons = document.querySelectorAll('.close-mobile-overlay');

    // Show overlays
    mobileSearchToggle?.addEventListener('click', () => showOverlay(mobileSearchOverlay));
    mobileFilterToggle?.addEventListener('click', () => showOverlay(mobileFilterOverlay));
    mobileSortToggle?.addEventListener('click', () => showOverlay(mobileSortOverlay));

    // Close overlays
    closeButtons.forEach(btn => {
        btn.addEventListener('click', hideAllOverlays);
    });

    // Availability filter buttons
    document.querySelectorAll('.availability-filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.availability-filter-btn').forEach(b => {
                b.classList.remove('border-primary', 'text-primary', 'bg-primary/5');
            });
            this.classList.add('border-primary', 'text-primary', 'bg-primary/5');
        });
    });

    // Sort options
    document.querySelectorAll('.sort-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.sort-option .check-icon').forEach(icon => icon.classList.add('hidden'));
            document.querySelectorAll('.sort-option').forEach(opt => opt.classList.remove('border-primary', 'bg-primary/5'));

            this.classList.add('border-primary', 'bg-primary/5');
            this.querySelector('.check-icon').classList.remove('hidden');

            // Apply sort
            const sortValue = this.dataset.sort;
            console.log('Sorting by:', sortValue);

            // Close overlay after selection
            setTimeout(() => hideAllOverlays(), 300);
        });
    });

    // Mobile view toggle
    let currentMobileView = 'list';
    mobileViewToggle?.addEventListener('click', function() {
        currentMobileView = currentMobileView === 'list' ? 'grid' : 'list';
        const icon = this.querySelector('.material-symbols-outlined');
        const text = this.querySelector('.text-xs');

        if (currentMobileView === 'grid') {
            icon.textContent = 'grid_view';
            text.textContent = 'To\'r';
            this.classList.add('text-primary');
        } else {
            icon.textContent = 'view_list';
            text.textContent = 'Ro\'yxat';
            this.classList.remove('text-primary');
        }

        // Update main view
        if (window.translatorsPage) {
            window.translatorsPage.currentView = currentMobileView;
            window.translatorsPage.updateViewLayout();
        }
    });

    function showOverlay(overlay) {
        if (overlay) {
            overlay.classList.remove('translate-y-full');
            overlay.classList.add('translate-y-0');
            document.body.style.overflow = 'hidden';
        }
    }

    function hideAllOverlays() {
        [mobileSearchOverlay, mobileFilterOverlay, mobileSortOverlay].forEach(overlay => {
            if (overlay) {
                overlay.classList.remove('translate-y-0');
                overlay.classList.add('translate-y-full');
            }
        });
        document.body.style.overflow = 'auto';
    }

    // Apply mobile filters function
    window.applyMobileFilters = function() {
        const params = new URLSearchParams();

        // Get selected language
        const language = document.querySelector('#mobile-filter-overlay select').value;
        if (language) params.append('language', language);

        // Get selected experience
        const experience = document.querySelector('input[name="mobile-experience"]:checked')?.value;
        if (experience && experience !== 'all') params.append('experience', experience);

        // Get selected availability
        const availability = document.querySelector('.availability-filter-btn.border-primary')?.dataset.value;
        if (availability && availability !== 'all') params.append('availability', availability);

        // Redirect with filters
        const url = "{{ route('translators') }}" + (params.toString() ? '?' + params.toString() : '');
        window.location.href = url;
    };

    // Initialize first sort option as selected
    document.querySelector('.sort-option[data-sort="rating"]')?.click();
});
</script>
