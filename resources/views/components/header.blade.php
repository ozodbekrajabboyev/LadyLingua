<header class="sticky top-0 z-50 w-full bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-[#e5e7eb] dark:border-gray-800 px-6 lg:px-40 py-4">
    <div class="max-w-[1200px] mx-auto flex items-center justify-between">
        <div class="flex items-center gap-8">
            <div class="flex items-center gap-3">
                <div class="text-white p-1.5 flex items-center justify-center">
                    <img src="{{ asset('logo.png') }}" alt="LadyLingua Logo" class="h-11 w-11 object-contain">
                </div>
                <h1 class="text-xl font-bold tracking-tight text-primary">LadyLingo</h1>
            </div>
            <nav class="hidden md:flex items-center gap-8">
                <a class="text-primary text-sm font-semibold border-b-2 border-primary pb-1" href="/">Explore</a>
                <a class="text-gray-600 dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">Tarjimonlar</a>
                <a class="text-gray-600 dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">Tarjimalar</a>
            </nav>
        </div>
        <div class="flex items-center gap-3">
            <a class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary transition-colors px-4 py-2" href="/platform/login">
                Kirish
            </a>
            <a class="bg-primary text-white text-sm font-bold px-5 py-2.5 rounded-lg hover:bg-opacity-90 transition-all shadow-md shadow-primary/20" href="/platform/register">
                Ro'yxatdan o'tish
            </a>
        </div>
    </div>
</header>
