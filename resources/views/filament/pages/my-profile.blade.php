<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}
        <br>
        <div class="mt-6">
            <x-filament::button type="submit">
                Saqlash
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
