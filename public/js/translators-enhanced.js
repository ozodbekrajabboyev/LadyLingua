/**
 * Enhanced Translators Page JavaScript
 * Handles search, filtering, sorting, and UI interactions
 */

class TranslatorsPage {
    constructor() {
        this.searchTimeout = null;
        this.filterTimeout = null;
        this.currentView = 'list';
        this.isLoading = false;

        this.init();
    }

    init() {
        this.bindEvents();
        this.initializeFilters();
        this.initializeInfiniteScroll();
        this.initializeAnimations();
    }

    bindEvents() {
        // Search functionality
        const searchInput = document.getElementById('translator-search');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.handleSearch(e.target.value);
            });
        }

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.handleQuickFilter(e.target);
            });
        });

        // View toggles
        document.querySelectorAll('.view-toggle').forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                this.handleViewChange(e.target);
            });
        });

        // Form changes
        const searchForm = document.getElementById('search-form');
        if (searchForm) {
            searchForm.addEventListener('change', () => {
                this.handleFormChange();
            });
        }

        // Favorite buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.favorite-btn')) {
                this.handleFavorite(e.target.closest('.favorite-btn'));
            }
        });

        // Quick message buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.quick-message-btn')) {
                this.handleQuickMessage(e.target.closest('.quick-message-btn'));
            }
        });
    }

    handleSearch(query) {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            this.performSearch(query);
        }, 300);
    }

    performSearch(query) {
        if (this.isLoading) return;

        this.showLoading();

        // Create form data
        const formData = new FormData();
        formData.append('search', query);

        // Add other active filters
        const form = document.getElementById('search-form');
        if (form) {
            const data = new FormData(form);
            for (let [key, value] of data.entries()) {
                if (value.trim() !== '') {
                    formData.append(key, value);
                }
            }
        }

        // Simulate API call (replace with actual AJAX request)
        setTimeout(() => {
            this.hideLoading();
            this.updateResults();
            this.showSearchAnimation();
        }, 800);
    }

    handleQuickFilter(filterBtn) {
        // Update active filter button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-primary', 'text-white');
            btn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        });

        filterBtn.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        filterBtn.classList.add('active', 'bg-primary', 'text-white');

        // Apply filter logic
        const filterType = filterBtn.dataset.filter;
        this.applyQuickFilter(filterType);
    }

    applyQuickFilter(filterType) {
        const form = document.getElementById('search-form');
        if (!form) return;

        switch(filterType) {
            case 'all':
                form.reset();
                break;
            case 'top_rated':
                form.querySelector('[name="rating"]').value = '4';
                form.querySelector('[name="sort"]').value = 'rating';
                break;
            case 'available_now':
                form.querySelector('[name="availability"]').value = 'online';
                break;
            case 'verified':
                // Custom filter for verified translators
                break;
            case 'experienced':
                form.querySelector('[name="experience"]').value = 'expert';
                break;
        }

        this.handleFormChange();
    }

    handleViewChange(toggleBtn) {
        document.querySelectorAll('.view-toggle').forEach(btn => {
            btn.classList.remove('active', 'bg-white', 'dark:bg-gray-600', 'shadow-sm');
            btn.classList.add('text-gray-500');
        });

        toggleBtn.classList.add('active', 'bg-white', 'dark:bg-gray-600', 'shadow-sm');
        toggleBtn.classList.remove('text-gray-500');

        // Determine view type
        const isGridView = toggleBtn.querySelector('[class*="grid_view"]');
        this.currentView = isGridView ? 'grid' : 'list';

        this.updateViewLayout();
    }

    updateViewLayout() {
        const container = document.getElementById('translators-container');
        if (!container) return;

        if (this.currentView === 'grid') {
            container.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12';
            // Add grid-specific classes to cards
            container.querySelectorAll('.translator-card').forEach(card => {
                card.classList.add('grid-view');
            });
        } else {
            container.className = 'space-y-6 mb-12';
            // Remove grid-specific classes
            container.querySelectorAll('.translator-card').forEach(card => {
                card.classList.remove('grid-view');
            });
        }

        // Animate the transition
        this.animateLayoutChange();
    }

    handleFormChange() {
        clearTimeout(this.filterTimeout);
        this.filterTimeout = setTimeout(() => {
            this.updateActiveFilters();
            this.performSearch('');
        }, 500);
    }

    handleFavorite(favoriteBtn) {
        const translatorId = favoriteBtn.dataset.translatorId;
        const icon = favoriteBtn.querySelector('.material-symbols-outlined');

        // Toggle favorite state
        if (favoriteBtn.classList.contains('favorited')) {
            favoriteBtn.classList.remove('favorited');
            icon.textContent = 'favorite_border';
            favoriteBtn.classList.remove('text-red-500');
            favoriteBtn.classList.add('text-gray-400');
            this.showToast('Sevimlilerdan olib tashlandi', 'info');
        } else {
            favoriteBtn.classList.add('favorited');
            icon.textContent = 'favorite';
            favoriteBtn.classList.add('text-red-500');
            favoriteBtn.classList.remove('text-gray-400');
            this.showToast('Sevimlilarga qo\'shildi!', 'success');
        }

        // Animate heart
        favoriteBtn.style.transform = 'scale(1.2)';
        setTimeout(() => {
            favoriteBtn.style.transform = 'scale(1)';
        }, 200);

        // Send to server (mock)
        this.updateFavoriteStatus(translatorId, favoriteBtn.classList.contains('favorited'));
    }

    handleQuickMessage(messageBtn) {
        const translatorId = messageBtn.dataset.translatorId;
        const translatorName = messageBtn.dataset.translatorName;

        this.openMessageModal(translatorId, translatorName);
    }

    openMessageModal(translatorId, translatorName) {
        // Create and show message modal
        const modal = this.createMessageModal(translatorId, translatorName);
        document.body.appendChild(modal);

        // Animate modal appearance
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.modal-content').classList.remove('scale-95');
            modal.querySelector('.modal-content').classList.add('scale-100');
        }, 10);
    }

    createMessageModal(translatorId, translatorName) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 opacity-0 transition-opacity duration-300';
        modal.innerHTML = `
            <div class="modal-content bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full transform scale-95 transition-transform duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Xabar yuborish</h3>
                    <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-sm">person</span>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">${translatorName}</div>
                        <div class="text-sm text-gray-500">Professional Translator</div>
                    </div>
                </div>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mavzu</label>
                        <input type="text" class="w-full rounded-lg border border-gray-200 dark:border-gray-600 px-3 py-2 bg-white dark:bg-gray-700 dark:text-white" placeholder="Xabar mavzusi...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Xabar</label>
                        <textarea rows="4" class="w-full rounded-lg border border-gray-200 dark:border-gray-600 px-3 py-2 bg-white dark:bg-gray-700 dark:text-white" placeholder="Xabaringizni yozing..."></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="this.closest('.fixed').remove()" class="px-4 py-2 text-gray-500 hover:text-gray-700">Bekor qilish</button>
                        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">send</span>
                            Yuborish
                        </button>
                    </div>
                </form>
            </div>
        `;
        return modal;
    }

    showLoading() {
        this.isLoading = true;
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    hideLoading() {
        this.isLoading = false;
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    updateResults() {
        // Update URL without refreshing
        const form = document.getElementById('search-form');
        if (form) {
            const formData = new FormData(form);
            const params = new URLSearchParams();

            for (let [key, value] of formData.entries()) {
                if (value.trim() !== '') {
                    params.append(key, value);
                }
            }

            const newUrl = `${window.location.pathname}${params.toString() ? '?' + params.toString() : ''}`;
            history.replaceState({}, '', newUrl);
        }
    }

    updateActiveFilters() {
        const form = document.getElementById('search-form');
        const activeFiltersDiv = document.getElementById('active-filters');
        const filterTagsDiv = document.getElementById('filter-tags');

        if (!form || !activeFiltersDiv || !filterTagsDiv) return;

        const formData = new FormData(form);
        const tags = [];

        for (let [key, value] of formData.entries()) {
            if (value && value.trim() !== '') {
                tags.push({
                    key: key,
                    value: value,
                    label: this.getFilterLabel(key, value)
                });
            }
        }

        if (tags.length > 0) {
            activeFiltersDiv.classList.remove('hidden');
            filterTagsDiv.innerHTML = tags.map(tag => `
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full animate-fadeIn">
                    ${tag.label}
                    <button type="button" onclick="window.translatorsPage.removeFilter('${tag.key}')" class="ml-1 hover:text-primary/70">
                        <span class="material-symbols-outlined text-xs">close</span>
                    </button>
                </span>
            `).join('');
        } else {
            activeFiltersDiv.classList.add('hidden');
        }
    }

    getFilterLabel(key, value) {
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

    removeFilter(key) {
        const element = document.querySelector(`[name="${key}"]`);
        if (element) {
            element.value = '';
            this.updateActiveFilters();
            this.handleFormChange();
        }
    }

    clearAllFilters() {
        const form = document.getElementById('search-form');
        if (form) {
            form.reset();
            document.querySelector('.filter-btn[data-filter="all"]')?.click();
            this.updateActiveFilters();
        }
    }

    initializeFilters() {
        // Initialize active filters on page load
        this.updateActiveFilters();
    }

    initializeInfiniteScroll() {
        // Add infinite scroll functionality
        let isLoadingMore = false;

        window.addEventListener('scroll', () => {
            if (isLoadingMore) return;

            const scrollPosition = window.innerHeight + window.scrollY;
            const documentHeight = document.documentElement.offsetHeight;

            if (scrollPosition >= documentHeight - 1000) {
                this.loadMoreResults();
            }
        });
    }

    loadMoreResults() {
        // Mock infinite loading
        console.log('Loading more results...');
    }

    initializeAnimations() {
        // Initialize intersection observer for animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                }
            });
        }, { threshold: 0.1 });

        // Observe translator cards
        document.querySelectorAll('.translator-card').forEach(card => {
            observer.observe(card);
        });
    }

    showSearchAnimation() {
        const container = document.getElementById('translators-container');
        if (container) {
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';

            setTimeout(() => {
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
                container.style.transition = 'all 0.4s ease';
            }, 100);
        }
    }

    animateLayoutChange() {
        const cards = document.querySelectorAll('.translator-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'scale(0.9)';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
                card.style.transition = 'all 0.3s ease';
            }, index * 50);
        });
    }

    updateFavoriteStatus(translatorId, isFavorited) {
        // Mock API call
        console.log(`Updating favorite status for translator ${translatorId}: ${isFavorited}`);
    }

    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white z-50 animate-slideIn ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        }`;
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.translatorsPage = new TranslatorsPage();
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-slideIn {
        animation: slideIn 0.3s ease-out;
    }

    .translator-card {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease-out;
    }

    .translator-card.animate-fadeInUp {
        opacity: 1;
        transform: translateY(0);
    }
`;
document.head.appendChild(style);
