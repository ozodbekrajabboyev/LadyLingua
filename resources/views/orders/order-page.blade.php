@extends('layouts.app')

<x-modal-backdrop-skeleton />

<x-order-modal specialistName="Maria Garcia" status="Kutilmoqda (pending)">

    {{-- Project Selection --}}
    <x-form-field label="Loyiha nomi" icon="unfold_more">
        <select class="form-select w-full rounded-lg text-[#121117] focus:ring-2 focus:ring-primary/20 border border-[#dcdce5] dark:border-gray-700 bg-white dark:bg-[#2a293d] focus:border-primary h-12 px-4 text-base font-normal appearance-none">
            <option disabled selected value="">Loyihani tanlang...</option>
            <option value="1">Texnik hujjatlar tarjimasi</option>
            <option value="2">Veb-sayt mahalliylashtirish</option>
            <option value="3">Badiiy matn tahriri</option>
        </select>
    </x-form-field>

    <div class="flex flex-col md:flex-row gap-5">
        {{-- Language Selection --}}
        <x-form-field label="Tarjima tili" icon="language">
            <select class="form-select w-full rounded-lg text-[#121117] focus:ring-2 focus:ring-primary/20 border border-[#dcdce5] dark:border-gray-700 bg-white dark:bg-[#2a293d] focus:border-primary h-12 px-4 text-base font-normal appearance-none">
                <option disabled selected value="">Tilni tanlang</option>
                <option value="en-uz">Inglizcha - O'zbekcha</option>
                <option value="ru-uz">Ruscha - O'zbekcha</option>
            </select>
        </x-form-field>

        {{-- Deadline --}}
        <x-form-field label="Muddati">
            <input class="form-input w-full rounded-lg text-[#121117] focus:ring-2 focus:ring-primary/20 border border-[#dcdce5] dark:border-gray-700 bg-white dark:bg-[#2a293d] focus:border-primary h-12 px-4 text-base font-normal" type="datetime-local"/>
        </x-form-field>
    </div>

    {{-- Description --}}
    <x-form-field label="Loyiha tavsifi">
        <textarea class="form-textarea w-full rounded-lg text-[#121117] focus:ring-2 focus:ring-primary/20 border border-[#dcdce5] dark:border-gray-700 bg-white dark:bg-[#2a293d] focus:border-primary min-h-[120px] placeholder:text-[#656487] p-4 text-base font-normal leading-relaxed resize-none" placeholder="Loyiha haqida batafsil ma'lumot qoldiring..."></textarea>
    </x-form-field>

</x-order-modal>
