<!-- Advanced Search and Filters Component -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
    <!-- Search Header -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-primary">tune</span>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Qidiruv va Filtrlar</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">O'zingizga mos tarjimonni toping</p>
        </div>
        <a href="{{ route('translators') }}" class="ml-auto px-4 py-2 text-sm text-gray-500 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-sm mr-1">refresh</span>
            Tozalash
        </a>
    </div>

    <form id="search-form" method="GET" action="{{ route('translators') }}" class="space-y-6">
        <!-- Main Search Row -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Search Input -->
            <div class="lg:col-span-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Qidiruv</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <span class="material-symbols-outlined text-gray-400">search</span>
                    </div>
                    <input
                        id="translator-search"
                        name="search"
                        class="block w-full rounded-xl border-0 py-4 pl-12 pr-4 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm bg-gray-50 dark:bg-gray-700 dark:text-white transition-all duration-200 focus:bg-white dark:focus:bg-gray-600"
                        placeholder="Ism, sohasi yoki til bo'yicha qidiring..."
                        type="text"
                        value="{{ request('search') }}">
                </div>
            </div>

            <!-- Language Filter -->
            <div class="lg:col-span-3">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Til</label>
                <select name="language" class="block w-full rounded-xl border-0 py-4 px-4 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm bg-gray-50 dark:bg-gray-700 dark:text-white transition-all duration-200">
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
            <div class="lg:col-span-3">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimal reyting</label>
                <select name="rating" class="block w-full rounded-xl border-0 py-4 px-4 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm bg-gray-50 dark:bg-gray-700 dark:text-white transition-all duration-200">
                    <option value="">Barcha reytinglar</option>
                    @if($availableRatings->isNotEmpty())
                        @foreach($availableRatings->sortDesc() as $rating)
                            <option value="{{ $rating }}" {{ request('rating') == $rating ? 'selected' : '' }}>
                                {{ $rating }}+ yulduz
                            </option>
                        @endforeach
                    @else
                        <option value="5">5 yulduz</option>
                        <option value="4">4+ yulduz</option>
                        <option value="3">3+ yulduz</option>
                        <option value="2">2+ yulduz</option>
                    @endif
                </select>
            </div>
        </div>

        <!-- Quick Filters -->
        <div class="flex flex-wrap items-center gap-3 pt-6 border-t border-gray-100 dark:border-gray-600">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tez filtrlar:</span>
            <button type="button" data-filter="all" class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-primary text-white">
                Barchasi
            </button>
            <button type="button" data-filter="top_rated" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined text-xs mr-1">star</span>
                Eng yuqori reyting
            </button>
            <button type="button" data-filter="available_now" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined text-xs mr-1">schedule</span>
                Hozir mavjud
            </button>
            <button type="button" data-filter="verified" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined text-xs mr-1">verified</span>
                Tasdiqlangan
            </button>
            <button type="button" data-filter="experienced" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined text-xs mr-1">workspace_premium</span>
                Ko'p tajribali
            </button>
        </div>
    </form>

    <!-- Active Filters Display -->
    <div id="active-filters" class="hidden mt-4 pt-4 border-t border-gray-100 dark:border-gray-600">
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Faol filtrlar:</span>
            <div id="filter-tags" class="flex flex-wrap gap-2"></div>
            <a href="{{ route('translators') }}" class="ml-auto text-sm text-primary hover:text-primary/80 transition-colors">
                Barchasini o'chirish
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const activeFiltersDiv = document.getElementById('active-filters');
    const filterTagsDiv = document.getElementById('filter-tags');

    // Handle filter buttons
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => {
                b.classList.remove('active', 'bg-primary', 'text-white');
                b.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
            });

            this.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
            this.classList.add('active', 'bg-primary', 'text-white');

            applyQuickFilter(this.dataset.filter);
        });
    });

    // Handle form changes
    searchForm.addEventListener('change', function() {
        updateActiveFilters();
        // Auto-submit form with debounce
        clearTimeout(window.filterTimeout);
        window.filterTimeout = setTimeout(() => {
            searchForm.submit();
        }, 500);
    });

    // Handle search input with debounce
    document.getElementById('translator-search').addEventListener('input', function() {
        clearTimeout(window.searchTimeout);
        window.searchTimeout = setTimeout(() => {
            updateActiveFilters();
            // Submit form for search
            searchForm.submit();
        }, 800);
    });

    function applyQuickFilter(filter) {
        const form = document.getElementById('search-form');

        switch(filter) {
            case 'all':
                // Redirect to clear all filters
                window.location.href = "{{ route('translators') }}";
                return;
            case 'top_rated':
                form.querySelector('[name="rating"]').value = '4';
                form.querySelector('[name="sort"]').value = 'rating';
                break;
            case 'available_now':
                form.querySelector('[name="availability"]').value = 'online';
                break;
            case 'verified':
                // Custom filter logic - could be implemented later
                break;
            case 'experienced':
                form.querySelector('[name="experience"]').value = 'expert';
                break;
        }

        updateActiveFilters();
        form.submit();
    }

    function updateActiveFilters() {
        const formData = new FormData(searchForm);
        const tags = [];

        for (let [key, value] of formData.entries()) {
            if (value && value.trim() !== '') {
                tags.push({
                    key: key,
                    value: value,
                    label: getFilterLabel(key, value)
                });
            }
        }

        if (tags.length > 0) {
            activeFiltersDiv.classList.remove('hidden');
            filterTagsDiv.innerHTML = tags.map(tag => `
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full">
                    ${tag.label}
                    <button type="button" onclick="removeFilter('${tag.key}')" class="ml-1 hover:text-primary/70">
                        <span class="material-symbols-outlined text-xs">close</span>
                    </button>
                </span>
            `).join('');
        } else {
            activeFiltersDiv.classList.add('hidden');
        }
    }

    function getFilterLabel(key, value) {
        const labels = {
            search: `Qidiruv: "${value}"`,
            language: `Til: ${value.toUpperCase()}`,
            rating: `${value}+ yulduz`,
            experience: value === 'beginner' ? 'Yangi' : value === 'intermediate' ? 'O\'rtacha' : 'Mutaxassis',
            specialization: value.charAt(0).toUpperCase() + value.slice(1),
            availability: value === 'online' ? 'Onlayn' : value === 'today' ? 'Bugun' : 'Shu hafta',
            sort: 'Saralash: ' + value
        };

        return labels[key] || `${key}: ${value}`;
    }

    window.removeFilter = function(key) {
        const element = document.querySelector(`[name="${key}"]`);
        if (element) {
            element.value = '';
            updateActiveFilters();
            searchForm.submit();
        }
    };

    window.clearAllFilters = function() {
        window.location.href = "{{ route('translators') }}";
    };

    // Initialize
    updateActiveFilters();
});
</script>
