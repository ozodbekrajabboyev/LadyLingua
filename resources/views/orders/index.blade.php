@extends('layouts.app')

@section('title', 'Buyurtmalarim - Tarjimonlar Platformasi')

@section('content')
    <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
        <div class="flex flex-col gap-2">
            <h1 class="text-3xl font-black leading-tight tracking-tight text-[#121117] dark:text-white md:text-4xl">Buyurtmalarim</h1>
            <p class="text-base text-gray-500 dark:text-gray-400">Faol va yakunlangan loyihalar ro'yxati</p>
        </div>
        <button class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-primary px-5 text-sm font-medium text-white transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Yangi buyurtma
        </button>
    </div>

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mt-8">
        <div class="relative w-full lg:max-w-md">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                <span class="material-symbols-outlined">search</span>
            </div>
            <input class="block w-full rounded-lg border-0 bg-white dark:bg-gray-900 py-3 pl-10 pr-4 text-sm text-[#121117] dark:text-white placeholder:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none" placeholder="Buyurtma raqami yoki loyiha nomini qidirish..." type="text">
        </div>
        <div class="flex gap-2 overflow-x-auto pb-2 lg:pb-0 scrollbar-hide">
            <button class="whitespace-nowrap rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white transition-colors">
                Barchasi
            </button>
            <button class="whitespace-nowrap rounded-lg bg-white dark:bg-gray-900 px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Kutilmoqda
            </button>
            <button class="whitespace-nowrap rounded-lg bg-white dark:bg-gray-900 px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Jarayonda
            </button>
            <button class="whitespace-nowrap rounded-lg bg-white dark:bg-gray-900 px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Yakunlandi
            </button>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm overflow-hidden mt-8 mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Loyiha nomi</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Tarjimon</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Holat</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Sana / Narx</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400 text-right">Amal</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @include('orders.partials.order-row', [
                    'id' => '#48293',
                    'title' => 'Marketing strategiyasi hujjati',
                    'translator' => 'Azizbek T.',
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDeysqd9iXo09ROQMWpp0wI-FfDyZjsmLljm9-0iLBP0d8IX_PyMEXBmJvzdkHhGlQZEqrqa0hBq2y6i-OqgcjgGY-HfyDpf1eQT84keOq9iZ_iGFwQhcJ24r3W2T4gvp44P6ax_EvKhn5Rkfn3UphhShlevuBoP7Eb-m3NNV7wZJmJs_ACcStMDF9mzj9lmFVPoJnBKs3ZofT7ySCB8vJU-efTduE9i0sT77kMDt_SLWNDD24Y3OW-zs394yaU-HUik9cRp5bwQWM',
                    'status' => 'progress',
                    'date' => '12 Okt, 2023',
                    'price' => '150,000 UZS',
                    'action' => 'visibility'
                ])

                @include('orders.partials.order-row', [
                    'id' => '#48290',
                    'title' => 'Texnik qo\'llanma tarjimasi',
                    'translator' => 'Malika D.',
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAxcRz68ZhVnNEb60j8ShuhUWDGBBOCaV2I0IwrI1ZJ4yZSj2_v1OrDm1NQzHNN4OK4FGrndV6OqpYapDzCBXkSpr77Hat35IscSsZPsf0XxCPV_uXskr6_kH7U-_8Y7IVawkbmf9aVmVuSde5IExEIyu16bZpE7RanIWBmQfJe-gDNLIm0TCYrWFbO0jHk2xWwiaSWy8LBKpJXJSL4LlA4Cj4O33WxJg_9Syxo6qAnBeRcOu1T-6NyJTi6vZMh1_nK5Ndc20KAZyg',
                    'status' => 'pending',
                    'date' => '10 Okt, 2023',
                    'price' => '80,000 UZS',
                    'action' => 'edit'
                ])

                @include('orders.partials.order-row', [
                    'id' => '#48110',
                    'title' => 'Veb-sayt lokalizatsiyasi',
                    'translator' => 'Javlon B.',
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDLCrhx47SxQuQAbYYB-P3MYDNU-go9XOV1pggEUaQg_iMOQI56Z6bps0BbVE--1pfBvPFQ1cHVMRaozb2GdQEeNayOd5V0GhITnbAifZ4ty3rGMUy-OjEHUnEPVQtomYrbrhQEzxcRLFxfMVGEuHA-zpbPaeq9hZEBfyJZuj-HUERjdNWH1CWjgg4lHiW36RwE4VDcdNnyFNsqpTnTH4sIwlKQpl4qDQ5luOcMAQ5LBg_q35U7UaBCKSzbVJMeUURee-Zci-q1FrM',
                    'status' => 'completed',
                    'date' => '05 Sent, 2023',
                    'price' => '1,200,000 UZS',
                    'action' => 'download'
                ])

                @include('orders.partials.order-row', [
                    'id' => '#47992',
                    'title' => 'Mobil ilova matnlari',
                    'translator' => 'Sarvar K.',
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCg2BPv2581z6XfON6gksSs7NHd1uitZURBOqKwKCJwqQSB8KPEUFYY-QupOXmVqvFZfIfkFLKeXVKdURlvx422gZoz8NKEJlb2QLxFHOqRcID9wGKgcoosSYG92xXlw-DwTG_U_QszptesmLTswapYFx8p7nwqWEZN-dryWJWt9Botx87GvJgpabNIB4MVd2pl08dRYrJ3ay8WbV9dRxQw5Y8V2LqNPmq6yrYgnez14_ZzmhqAVeSKPgnm_6bC7qu3LtAjvCH0YvI',
                    'status' => 'completed',
                    'date' => '28 Avg, 2023',
                    'price' => '500,000 UZS',
                    'action' => 'download'
                ])

                @include('orders.partials.order-row', [
                    'id' => '#47900',
                    'title' => 'Yuridik shartnoma',
                    'translator' => null,
                    'avatar' => null,
                    'status' => 'pending',
                    'date' => '20 Avg, 2023',
                    'price' => '200,000 UZS',
                    'action' => 'delete'
                ])
                </tbody>
            </table>
        </div>

        @include('orders.partials.table-pagination')
    </div>
@endsection
