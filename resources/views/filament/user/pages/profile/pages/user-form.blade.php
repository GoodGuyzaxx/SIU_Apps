<x-filament::page>
    <form wire:submit.prevent="create">
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
</x-filament::page>
