<header class="sticky top-0 z-50 w-full bg-white/95 dark:bg-background-dark/95 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo and Brand Section -->
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center gap-4">
                    <div class="relative">
                        <img src="{{ asset('logo.png') }}" alt="LadyLingua Logo" class="h-14 w-14 object-contain drop-shadow-md">
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-black tracking-tight text-primary">LadyLingo</h1>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium tracking-wide">Professional Translation</span>
                    </div>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-8">
                <a class="{{ request()->is('/') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-gray-600 dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors' }}" href="/">Explore</a>
                <a class="{{ request()->is('translators') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-gray-600 dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors' }}" href="/translators">Tarjimonlar</a>
                <a class="{{ request()->is('translations') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-gray-600 dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors' }}" href="/translations">Tarjimalar</a>
                @auth
                    <a class="{{ request()->is('orders') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-gray-600 dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors' }}" href="/orders">Buyurtmalarim</a>
                @endauth
            </nav>

            <!-- User Actions -->
            <div class="flex items-center gap-4">
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

        <!-- Mobile Menu Button (for future mobile nav) -->
        <div class="lg:hidden">
            <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 p-2">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        </div>
    </div>
</header>
