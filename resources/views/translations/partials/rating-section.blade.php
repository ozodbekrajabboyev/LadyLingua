<div class="bg-white dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
    <h3 class="text-lg font-bold text-[#121117] dark:text-white mb-4">Fikrlar va Baholar</h3>

    {{-- Rating Display --}}
    <div class="flex items-end gap-2 mb-2">
        <span class="text-5xl font-bold text-[#121117] dark:text-white">4.8</span>
        <div class="pb-2 text-yellow-500 flex text-xl">
            <span class="material-symbols-outlined filled-icon">star</span>
            <span class="material-symbols-outlined filled-icon">star</span>
            <span class="material-symbols-outlined filled-icon">star</span>
            <span class="material-symbols-outlined filled-icon">star</span>
            <span class="material-symbols-outlined filled-icon" style="font-variation-settings: 'FILL' 0.5;">star_half</span>
        </div>
    </div>
    <p class="text-sm text-gray-500 mb-6">124 ta foydalanuvchi baholagan</p>

    <hr class="border-gray-100 dark:border-gray-800 mb-6"/>

    {{-- Review Form --}}
    <form>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            O'z fikringizni qoldiring
        </label>

        {{-- Star Rating Input --}}
        <div class="flex gap-1 text-gray-300 mb-3 cursor-pointer">
            <span class="material-symbols-outlined hover:text-yellow-400 transition">star</span>
            <span class="material-symbols-outlined hover:text-yellow-400 transition">star</span>
            <span class="material-symbols-outlined hover:text-yellow-400 transition">star</span>
            <span class="material-symbols-outlined hover:text-yellow-400 transition">star</span>
            <span class="material-symbols-outlined hover:text-yellow-400 transition">star</span>
        </div>

        {{-- Review Text --}}
        <textarea
            class="w-full bg-[#f1f0f4] dark:bg-gray-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary mb-3 resize-none h-24"
            placeholder="Tarjima sifati haqida nima deysiz?"
        ></textarea>

        {{-- Submit Button --}}
        <button
            type="button"
            class="w-full bg-white border border-gray-200 dark:border-gray-700 dark:bg-transparent text-[#121117] dark:text-white font-medium py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition">
            Yuborish
        </button>
    </form>
</div>
