@extends('layouts.app')

@section('title', 'Tarjimonlar Ro\'yxati - LadyLingua')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-[#121117] dark:text-white tracking-tight">Tarjimonlar</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Tajribali va saralangan tarjimonlar hamjamiyati</p>
        </div>
    </div>

    <div class="mb-8">
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="material-symbols-outlined text-gray-400">search</span>
            </div>
            <input class="block w-full rounded-xl border-0 py-3 pl-10 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 bg-white dark:bg-gray-900 dark:ring-gray-700 dark:text-white shadow-sm" placeholder="Tarjimonning ismi yoki sohasi bo'yicha qidirish..." type="text">
        </div>
    </div>

    <div class="space-y-4 mb-12">
        @include('translators.partials.translator-card', [
            'name' => 'Aziza Karimova',
            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBMjmObXc6FkajABCYe0v1frjAoY8617g6N-rAZFQgoZJEARqd4fTRbehFEm-swyUP7sfckj48QSsqgSPB7W92E42LhkrYYIvjBR9B5kO_n1zZDVQ-3_OB7oD_KXnJOyCzo4kLSOxNzJr2ABv_ZECwXHNBrPSI3rQUaR0qHvks-PNnRkVjZHFPjcTicUGofXSaJX_p4u6dWHquuMxVfoDo5HOgyaGYCns99RQJOXk-VYk8eAy6HAfBRJMlpv0Gztuc6qCRMv5r5FxE',
            'rating' => '4.9',
            'reviews' => '124',
            'description' => '7 yillik tajribaga ega badiiy va texnik matnlar tarjimoni. Dunyo adabiyoti durdonalarini o\'zbek tiliga mahorat bilan o\'girish bo\'yicha mutaxassis.',
            'languages' => ['EN', 'UZ', 'RU']
        ])

        @include('translators.partials.translator-card', [
            'name' => 'Bekzod Rashidov',
            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCcltNledY0LmA8OVMWaye6hTo3tq2DuaFYsKwHn1f991CcSp_TSZTXvkn6UPcWBtiYpCyGy1dJxBqa7zdE_b4nvS4WENQ2qHSeS4BXW5vZPJk-qA7ICKLvGEEYt0uDYHRK4669oVI4ZrtFxmtOXvyubBqd-f3b9bfE1wcGI5R6lXvKYtPsyzgXcovOfrY_qvOR3ELxDBHkwKL_oSVdaZridLco7kJr6UvM4ywvg6HoL6FZPjD4zHSV8LGnZN_kFad9Jwp2DCzQvOg',
            'rating' => '4.7',
            'reviews' => '89',
            'description' => 'Iqtisodiyot va biznes yo\'nalishidagi hujjatlar tarjimoni. Shartnomalar, moliyaviy hisobotlar va biznes loyihalarni sifatli tarjima qiladi.',
            'languages' => ['RU', 'UZ']
        ])

        @include('translators.partials.translator-card', [
            'name' => 'Madina To\'rayeva',
            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBp_1m0DIYbUKbuGsp1CHr2bRNW52jkJlAUk2h2JCq0mILDQoK8M5tpK62RUV5UNMIwMM_LggYKr0f7tXgdMkaCiMKVoU5dO6PeXV3mmvq6yyhba5rJ44bauGMcCEKB-Qu-pYY0mMyhi12mDCkqBaHHhgFN35Yj1fh9aIJkoky1mepOzUbHgBbecnq8FhI-kiqpa2ijhIta15pcc0_XhE73AOTByv2Oc9E1KsmaaTqi_s8WVVqWRyefQfJAyCp6WkazAB4_e_NjEQ0',
            'rating' => '5.0',
            'reviews' => '215',
            'description' => 'Sinchron va ketma-ket tarjima ustasi. Xalqaro konferensiyalar va yuqori darajadagi uchrashuvlarda professional tarjimonlik xizmatlari.',
            'languages' => ['EN', 'UZ', 'TR']
        ])

        @include('translators.partials.translator-card', [
            'name' => 'Sardor Alimov',
            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAaCIn8iOXoKzag0MMmnd1POUemVdIjL9wKLuD18d1IRUE7cISob_m1qM4H9qO7maiQMSVEJypbwoiMTkw2mcXhISxObdiGVRJeCsS9TER6thagR-p1Kv3fwtZ6V0BF8LGS4fYK7F1Lsi_sKmrD4dRWukTRqippOeurvYV4iiWA8TI2V1ey-MbmG6V1cAhSinWKT9YD7zUdiN8_ViaUKxwPy-ekVeawRVyY4zZmlFiwVM9kVPg_XIRiDp_mtVkYXkpGIZ62S_W8KF4',
            'rating' => '4.5',
            'reviews' => '56',
            'description' => 'IT va dasturlash sohasiga ixtisoslashgan tarjimon. Texnik hujjatlar, dastur interfeyslari va o\'yinlarni mahalliylashtirish tajribasi.',
            'languages' => ['EN', 'RU', 'UZ']
        ])
    </div>

    @include('translations.partials.pagination')
@endsection
