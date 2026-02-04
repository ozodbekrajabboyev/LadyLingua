@extends('layouts.app')

<x-modal-backdrop-skeleton />

<x-order-modal specialistName="{{ Auth::user()->name ?? 'User' }}" status="Yangi buyurtma" action="{{ route('orders.store') }}" method="POST">
    @csrf

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-5">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="material-symbols-outlined text-red-400">error</span>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Xatoliklar mavjud</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Project Title --}}
    <x-form-field label="Loyiha nomi" icon="unfold_more">
        <input name="title"
               value="{{ old('title') }}"
               class="form-input w-full rounded-lg text-[#121117] focus:ring-2 focus:ring-primary/20 border border-[#dcdce5] dark:border-gray-700 bg-white dark:bg-[#2a293d] focus:border-primary h-12 px-4 text-base font-normal"
               type="text"
               placeholder="Loyiha nomini kiriting..."
               required>
    </x-form-field>

    <div class="flex flex-col md:flex-row gap-5">
        {{-- Translator Selection --}}
        <x-form-field label="Tarjimon tanlang" icon="person">
            <select name="translator_id"
                    class="form-select w-full rounded-lg text-[#121117] focus:ring-2 focus:ring-primary/20 border border-[#dcdce5] dark:border-gray-700 bg-white dark:bg-[#2a293d] focus:border-primary h-12 px-4 text-base font-normal appearance-none"
                    required>
                <option disabled {{ old('translator_id') ? '' : 'selected' }} value="">Tarjimonni tanlang</option>
                @foreach($translators as $translator)
                    <option value="{{ $translator->id }}" {{ old('translator_id') == $translator->id ? 'selected' : '' }}>
                        {{ $translator->user->name ?? 'Unknown' }}
                    </option>
                @endforeach
            </select>
        </x-form-field>

        {{-- Language Selection --}}
        <x-form-field label="Tarjima tili" icon="language">
            <select name="language_id"
                    class="form-select w-full rounded-lg text-[#121117] focus:ring-2 focus:ring-primary/20 border border-[#dcdce5] dark:border-gray-700 bg-white dark:bg-[#2a293d] focus:border-primary h-12 px-4 text-base font-normal appearance-none"
                    required>
                <option disabled {{ old('language_id') ? '' : 'selected' }} value="">Tilni tanlang</option>
                @foreach($languages as $language)
                    <option value="{{ $language->id }}" {{ old('language_id') == $language->id ? 'selected' : '' }}>
                        {{ $language->lang_name }}
                    </option>
                @endforeach
            </select>
        </x-form-field>
    </div>

    {{-- Deadline --}}
    <x-form-field label="Muddati">
        <input name="deadline"
               value="{{ old('deadline') }}"
               class="form-input w-full rounded-lg text-[#121117] focus:ring-2 focus:ring-primary/20 border border-[#dcdce5] dark:border-gray-700 bg-white dark:bg-[#2a293d] focus:border-primary h-12 px-4 text-base font-normal"
               type="datetime-local"
               min="{{ now()->format('Y-m-d\TH:i') }}"
               required/>
    </x-form-field>

    {{-- Description --}}
    <x-form-field label="Loyiha tavsifi">
        <textarea name="description"
                  class="form-textarea w-full rounded-lg text-[#121117] focus:ring-2 focus:ring-primary/20 border border-[#dcdce5] dark:border-gray-700 bg-white dark:bg-[#2a293d] focus:border-primary min-h-[120px] placeholder:text-[#656487] p-4 text-base font-normal leading-relaxed resize-none"
                  placeholder="Loyiha haqida batafsil ma'lumot qoldiring..."
                  required>{{ old('description') }}</textarea>
    </x-form-field>

</x-order-modal>
