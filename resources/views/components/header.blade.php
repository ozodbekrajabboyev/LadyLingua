<header class="sticky top-0 z-50 w-full bg-white/95 dark:bg-background-dark/95 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <!-- Logo and Brand Section -->
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center gap-2 lg:gap-4">
                    <div class="relative">
                        <a href="/"><img src="{{ asset('logo.png') }}" alt="LadyLingua Logo" class="h-10 w-10 lg:h-16 lg:w-16 object-contain drop-shadow-lg"></a>
                    </div>
                    <div class="flex flex-col">
                        <a href="/"><h1 class="text-lg lg:text-2xl font-black tracking-tight text-primary">LadyLingo</h1></a>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium tracking-wide uppercase hidden sm:block">Professional Tarjima</span>
                    </div>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-1">
                <a class="{{ request()->is('/') ? 'bg-primary/10 text-primary border-primary' : 'text-gray-600 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-800 border-transparent' }} px-5 py-3 text-sm font-semibold border-b-2 transition-all duration-200 rounded-t-lg" href="/">Explore</a>
                <a class="{{ request()->is('translators') ? 'bg-primary/10 text-primary border-primary' : 'text-gray-600 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-800 border-transparent' }} px-5 py-3 text-sm font-semibold border-b-2 transition-all duration-200 rounded-t-lg" href="/translators">Tarjimonlar</a>
                <a class="{{ request()->is('translations') ? 'bg-primary/10 text-primary border-primary' : 'text-gray-600 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-800 border-transparent' }} px-5 py-3 text-sm font-semibold border-b-2 transition-all duration-200 rounded-t-lg" href="/translations">Tarjimalar</a>
                @auth
                    <a class="{{ request()->is('orders') ? 'bg-primary/10 text-primary border-primary' : 'text-gray-600 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-800 border-transparent' }} px-5 py-3 text-sm font-semibold border-b-2 transition-all duration-200 rounded-t-lg" href="/orders">Buyurtmalarim</a>
                @endauth
            </nav>

            <!-- Desktop User Actions -->
            <div class="hidden lg:flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-700 dark:text-gray-200 font-medium">
                            Salom, {{ Auth::user()->name }}!
                        </span>

                        @if(Auth::user()->role !== 'user')
                            <a class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary transition-colors px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700"
                               href="/platform">
                                Admin Panel
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-red-600 transition-colors px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:border-red-300 hover:bg-red-50 dark:hover:bg-red-900/20">
                                Chiqish
                            </button>
                        </form>
                    </div>
                @else
                    <a class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary transition-colors px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800"
                       href="/platform/login">
                        Kirish
                    </a>
                    <a class="bg-primary text-white text-sm font-bold px-6 py-2.5 rounded-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/25 hover:shadow-primary/40 transform hover:scale-105"
                       href="/platform/register">
                        Ro'yxatdan o'tish
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button
                    type="button"
                    id="mobile-menu-button"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none focus:text-gray-700 p-2 rounded-lg transition-colors"
                    aria-label="Toggle mobile menu">
                    <svg id="menu-open" class="h-6 w-6 block" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="menu-close" class="h-6 w-6 hidden" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="lg:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white dark:bg-background-dark border-t border-gray-200 dark:border-gray-700 shadow-lg">
                <a class="{{ request()->is('/') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-800' }} block px-3 py-2 rounded-md text-base font-medium transition-all duration-200" href="/">Explore</a>
                <a class="{{ request()->is('translators') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-800' }} block px-3 py-2 rounded-md text-base font-medium transition-all duration-200" href="/translators">Tarjimonlar</a>
                <a class="{{ request()->is('translations') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-800' }} block px-3 py-2 rounded-md text-base font-medium transition-all duration-200" href="/translations">Tarjimalar</a>

                @auth
                    <a class="{{ request()->is('orders') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:text-primary hover:bg-gray-50 dark:hover:bg-gray-800' }} block px-3 py-2 rounded-md text-base font-medium transition-all duration-200" href="/orders">Buyurtmalarim</a>

                    <div class="border-t border-gray-200 dark:border-gray-700 mt-3 pt-3">
                        <div class="px-3 py-2">
                            <p class="text-sm text-gray-700 dark:text-gray-200 font-medium mb-2">
                                Salom, {{ Auth::user()->name }}!
                            </p>

                            @if(Auth::user()->role !== 'user')
                                <a class="block w-full text-left px-3 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary transition-colors bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 mb-2"
                                   href="/platform">
                                    Admin Panel
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="block w-full text-left px-3 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-red-600 transition-colors border border-gray-300 dark:border-gray-600 rounded-lg hover:border-red-300 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    Chiqish
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="border-t border-gray-200 dark:border-gray-700 mt-3 pt-3 px-3 space-y-2">
                        <a class="block w-full text-center px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary transition-colors border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800"
                           href="/platform/login">
                            Kirish
                        </a>
                        <a class="block w-full text-center bg-primary text-white text-sm font-bold px-6 py-2.5 rounded-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/25"
                           href="/platform/register">
                            Ro'yxatdan o'tish
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuOpen = document.getElementById('menu-open');
    const menuClose = document.getElementById('menu-close');

    if (mobileMenuButton && mobileMenu) {
        // Add backdrop element
        const backdrop = document.createElement('div');
        backdrop.className = 'fixed inset-0 bg-black/20 backdrop-blur-sm z-40 lg:hidden transition-opacity duration-300 opacity-0 invisible';
        backdrop.id = 'mobile-menu-backdrop';
        document.body.appendChild(backdrop);

        function openMenu() {
            mobileMenu.classList.remove('hidden');
            backdrop.classList.remove('invisible', 'opacity-0');
            backdrop.classList.add('opacity-100');
            menuOpen.classList.add('hidden');
            menuClose.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Animate menu items
            const menuItems = mobileMenu.querySelectorAll('a');
            menuItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 100);
            });
        }

        function closeMenu() {
            mobileMenu.classList.add('hidden');
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0', 'invisible');
            menuOpen.classList.remove('hidden');
            menuClose.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Toggle menu on button click
        mobileMenuButton.addEventListener('click', function() {
            const isMenuOpen = !mobileMenu.classList.contains('hidden');

            if (isMenuOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Close menu when clicking on a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                closeMenu();
            });
        });

        // Close menu when clicking on backdrop
        backdrop.addEventListener('click', closeMenu);

        // Close menu on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                closeMenu();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeMenu();
            }
        });
    }

    // Add smooth scroll behavior for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add scroll effect to header
    let lastScrollY = window.scrollY;
    const header = document.querySelector('header');

    window.addEventListener('scroll', () => {
        const currentScrollY = window.scrollY;

        if (header) {
            if (currentScrollY > lastScrollY && currentScrollY > 100) {
                // Scrolling down
                header.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                header.style.transform = 'translateY(0)';
            }

            // Add background blur when scrolled
            if (currentScrollY > 50) {
                header.classList.add('backdrop-blur-xl');
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
            } else {
                header.classList.remove('backdrop-blur-xl');
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
            }
        }

        lastScrollY = currentScrollY;
    });
});
</script>

