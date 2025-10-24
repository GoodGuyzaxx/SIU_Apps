<x-filament-panels::page>
    {{-- Page content --}}
    {{$this->informasiForm}}
    <x-filament::button
        wire:click="saveData"
        tag="a"
        color="success"
        icon="heroicon-o-check"
    >
        Print
    </x-filament::button>
</x-filament-panels::page>
