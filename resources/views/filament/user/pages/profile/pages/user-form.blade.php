<x-filament::page>
    <form wire:submit.prevent="create">
            {{ $this->form }}
        <br>
            <x-filament::button
                size="sl"
                type="submit"
                icon="heroicon-o-check">
                Simpan Data
            </x-filament::button>
    </form>
</x-filament::page>
