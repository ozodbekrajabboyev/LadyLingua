<section class="w-full bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-start gap-4">
            {{-- Book Cover --}}
            <div class="w-16 h-24 rounded bg-gray-200 bg-cover bg-center shadow-sm shrink-0"
                 data-alt="Cover of the book Alkimyogar"
                 style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC7p7cIOZm9hUBLfP66m2YzOBmY-W1mr6Jv3m42Uj36h9de7Qz8WzttAkrFku5wp72oXB4oKRRy8iqla1CppRqdQHfTkFxne0RG2xDxoZuMqvKiaGjWe1v8nx3Q5sS_vv9XWJaIr7OhBN6326yDWHrSCrlpxCVTzEVShO2OUtKFoRr2Ybbg_nP7AQkxO_XRweIRu7SS_nv7RD45Js2EWWoc-XeIClWL9rtBDXIBHbX5qBALqalVFLMeYiPucjWS8KNnT4e7XXB_X_Y');">
            </div>

            {{-- Book Info --}}
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#121117] dark:text-white leading-tight mb-1">
                    Alkimyogar (The Alchemist)
                </h1>

                <div class="flex flex-wrap gap-2 text-sm text-gray-500 dark:text-gray-400 items-center">
                    {{-- Author --}}
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">edit</span>
                        Muallif: <span class="font-medium text-gray-900 dark:text-gray-200">Paulo Coelho</span>
                    </span>

                    <span class="hidden md:inline text-gray-300">|</span>

                    {{-- Translator --}}
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">translate</span>
                        Tarjimon: <a class="font-medium text-primary hover:underline" href="#">Azizbek Qodirov</a>
                    </span>

                    <span class="hidden md:inline text-gray-300">|</span>

                    {{-- Rating --}}
                    <div class="flex items-center text-yellow-500">
                        <span class="material-symbols-outlined filled-icon text-lg">star</span>
                        <span class="ml-1 font-bold text-gray-900 dark:text-white">4.8</span>
                        <span class="text-gray-400 ml-1">(124 baho)</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button class="flex-1 md:flex-none h-10 px-4 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">bookmark_add</span>
                Saqlash
            </button>

            <button class="flex-1 md:flex-none h-10 px-6 rounded-lg bg-primary hover:bg-primary-dark text-white font-bold shadow-md transition flex items-center justify-center gap-2">
                <span>Sotib Olish</span>
                <span class="opacity-80 font-medium ml-1">15,000 UZS</span>
            </button>
        </div>
    </div>
</section>
