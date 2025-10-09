<x-filament-panels::page>
    {{-- Page content --}}
    <form wire:submit.prevent="save">
        <div class="p-6">
            {{ $this->form }}
        </div>
        <br>
        <div class="p-6">
            <x-filament::button
                size="sl"
                type="submit"
                icon="heroicon-o-check">
                Simpan Data
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
