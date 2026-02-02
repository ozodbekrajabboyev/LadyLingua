<aside class="lg:col-span-3 space-y-6">
    <div class="bg-white dark:bg-[#1a192a] p-5 rounded-xl border border-[#e5e7eb] dark:border-[#2a2a3a] shadow-sm">
        <h3 class="text-sm font-bold text-[#121117] dark:text-white uppercase tracking-wider mb-4">Bio</h3>
        <p class="text-[#656487] dark:text-gray-400 text-sm leading-relaxed mb-6">
            {{ $slot }}
        </p>

        <h3 class="text-sm font-bold text-[#121117] dark:text-white uppercase tracking-wider mb-3">Expertise</h3>
        <div class="flex flex-wrap gap-2 mb-6">
            <x-expertise-badge color="primary">English → Japanese</x-expertise-badge>
            <x-expertise-badge color="primary">Japanese → English</x-expertise-badge>
            <x-expertise-badge>Legal</x-expertise-badge>
            <x-expertise-badge>Technical</x-expertise-badge>
            <x-expertise-badge>Medical</x-expertise-badge>
            <x-expertise-badge>Software</x-expertise-badge>
        </div>

        <h3 class="text-sm font-bold text-[#121117] dark:text-white uppercase tracking-wider mb-3">Stats</h3>
        <div class="space-y-3">
            <x-stat-item label="Jobs Completed" value="452" />
            <x-stat-item label="Response Time" value="< 2 hours" />
            <x-stat-item label="Repeat Clients" value="84%" />
        </div>
    </div>
</aside>
