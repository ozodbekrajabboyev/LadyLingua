@props([
    'specialistName' => 'Maria Garcia',
    'specialistImage' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAdUI64J9XKR5f1FxBGZMdgbcz44fUMICt8jYuVOV97mwZR3onLBAU2NejH--PuSenxlKiCKD0MbdQyu7Oq_2w-PsnJn8JrMRecMUH9BXoSAipPDWUHAP2w2XctYXE7zI2gbO4qfgtYBEaHWSbnPWe1UrD1jWOnXzLZtxdTchjC6-QVgUz_MHQ0MFGYp3Gu-1Vl4GFB1EVLQArDMMRw8jR-hh5AffboSJY9t9t5hIPGKY6V9HZ2cyyqAw78e89yQTczXx89CiMNjY0',
    'status' => 'Kutilmoqda (pending)'
])

<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-[#1e1d2d] w-full max-w-[600px] rounded-xl shadow-2xl flex flex-col overflow-hidden">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-8 pt-8 pb-2">
            <h2 class="text-[#121117] dark:text-white text-2xl font-bold tracking-tight">Buyurtma berish</h2>
            <button class="text-[#656487] hover:text-[#121117] dark:hover:text-white transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        {{-- Specialist Info Bar --}}
        <div class="px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="size-6 rounded-full bg-center bg-cover" style="background-image: url('{{ $specialistImage }}');"></div>
                <p class="text-[#656487] dark:text-gray-400 text-sm font-normal">
                    Mutaxassis: <span class="font-semibold text-primary">{{ $specialistName }}</span>
                </p>
            </div>
            <div class="flex items-center gap-2 px-3 py-1 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-full">
                <span class="size-2 rounded-full bg-amber-500"></span>
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700 dark:text-amber-400">{{ $status }}</span>
            </div>
        </div>

        {{-- Form Content --}}
        <form {{ $attributes->merge(['class' => 'p-8 space-y-5']) }}>
            {{ $slot }}

            <div class="flex items-center justify-end gap-4 pt-4">
                <button class="px-6 py-2.5 text-sm font-bold text-[#656487] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors" type="button">
                    Bekor qilish
                </button>
                <button class="flex items-center justify-center gap-2 px-8 py-2.5 bg-primary hover:bg-[#4338ca] text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-primary/20" type="submit">
                    <span>Buyurtma berish</span>
                    <span class="material-symbols-outlined text-[18px]">send</span>
                </button>
            </div>
        </form>
    </div>
</div>
