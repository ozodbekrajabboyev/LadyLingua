@extends('layouts.app')

@section('title', 'LadyLingua - Tarjimalar Ro\'yxati')

@section('content')
    <section class="w-full max-w-[1200px] px-6 lg:px-40 py-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div class="max-w-xl">
                <h2 class="text-[#121117] dark:text-white text-4xl font-black leading-tight tracking-tight mb-2">
                    Tarjimalar Ro'yxati
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-lg">
                    Mavjud tarjimalarni ko'zdan kechiring va sifatli ishlarni kashf eting.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button class="flex items-center gap-2 px-4 py-2 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 transition-colors">
                    <span class="material-symbols-outlined text-lg">filter_list</span>
                    Saralash
                </button>
            </div>
        </div>

        <div class="space-y-0 border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden bg-white dark:bg-gray-900 shadow-sm">
            @include('translations.partials.translation-item', [
                'title' => 'Medical Research Paper: Immunology Protocols',
                'language' => 'EN → UZ',
                'description' => 'Zamonaviy immunologiya protokollari va so\'nggi klinik sinov natijalari haqidagi ilmiy maqolaning to\'liq tarjimasi. Tibbiy terminologiya aniq saqlangan.',
                'translator' => 'Alex Johnson',
                'rating' => '4.9',
                'time' => '2 soat oldin',
                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC9bjI5ADhoNg3pH0jiOdejkrsjEmhL3pc8aCobsNUrAro-IpxGGo6GzYHhwF5Yv4hYHuuv2SY7AIlh8G2zWyzeG7RIp23-NHPLfJSNfND-hnSSEM-UYgHqa0hwa6RNNtkBvw8t0g6LtZu99gexkRnbzdu26v7hIsEmSZWAcP5yXleHATYrjqfYmTkpNB1nYSlR819hti8XEFfzHWrthDzIgt_oaLIzhnwPUyn1_zQbFIbgvL6tog_zLaG28g3OO9qw1IlGf7dN-zA'
            ])

            @include('translations.partials.translation-item', [
                'title' => 'E-commerce App: UI Localization',
                'language' => 'FR → UZ',
                'description' => 'Hashamatli kiyim-kechak brendi uchun mo\'ljallangan mobil ilovaning foydalanuvchi interfeysini to\'liq mahalliylashtirish ishi.',
                'translator' => 'Sarah Chen',
                'rating' => '5.0',
                'time' => '5 soat oldin',
                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC8nf31r4FRPw0TxG1H-kybc9zij5xOvPbkTe7_JpXxnkjpTpOZdwx0kU_DPaQQOZg05aI73Urv_4TrWt5E8-Q0KfgqmETkau5Nnmt57topwJNu0FWnF-nmXMBRpsV34wfcNdj6KCAtlvEu5VZZ6Z4VyHmuUfBUSZ_uymnFZ4N6sJ24BzoDk8PO6RC-_l3PmQqXf7yLobvHbe-1nzUgDJvJxkMqaMzfxOrvlbTyWS72L-QVXMwUvDg92MUNKj9o80sSGXYkQOkvp3g'
            ])

            @include('translations.partials.translation-item', [
                'title' => 'Annual Financial Report 2023',
                'language' => 'DE → UZ',
                'description' => 'Rasmiy balans hisobotlari, audit natijalari va investorlar uchun ma\'lumotnomalar. Iqtisodiy terminlar bo\'yicha mukammal tarjima.',
                'translator' => 'Marcus Weber',
                'rating' => '4.8',
                'time' => 'Kecha',
                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC7NA-A9Ozm74RROTzGtrfODF8hHEIabAyFU8aIo7fhpZkwQm7K6WCedAF-78XXSPgW7z0M-i2i5wWIn7OP5d1hddxovJFlvmf_6zY2kHcTk-scTlIOm6Aq4nyaJVnh6gstzdeihzioDSKO6fnAt7QHcfLbSkO3o4Dm0cGE287OSaa_mfXYCb25pgNsrR5WvkpqDiF6VufTVhN8H3NG1KLexI3FvMIdyFbewiWtKXWPyajVzWmbyBsg8ZpeO2KoD74dM0nNHBSMkgo'
            ])

            @include('translations.partials.translation-item', [
                'title' => 'Legal Contract Review: Trade Agreement',
                'language' => 'IT → UZ',
                'description' => 'Ishlab chiqarish va eksport sektori uchun ikki tomonlama savdo shartnomasining huquqiy tahlili va tarjimasi.',
                'translator' => 'Elena Rossi',
                'rating' => '5.0',
                'time' => '2 kun oldin',
                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDJhv0-SCTNhsbPHG9QEKjtLam5zOa21Mi5EuEvDAcj5-iZGHDhtP2bWAZEY3p0rOMdd5EtKQdwcxNUw3GV44Gt1SFYs287hRmKwemD3lmVfToFBfPnCovN1ryHffjsAiQOAMPs0y4VQiyrRyCR_y_WGRie7Oz9aTHoErkFl1DZxwhAqVihoMzqGdyayT3EYFwjw1LFEW2GdMl9I3X7QKZBGAruEcL3nLIbtHcIs6MPjjUrCjZstQRXXcAFe3bpL2M2KK39gmRsyUE'
            ])
        </div>

        @include('translations.partials.pagination')
    </section>
@endsection
