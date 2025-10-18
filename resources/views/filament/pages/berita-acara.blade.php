<x-filament-panels::page>
    {{-- Page content --}}
    {{$this->cetakForm}}

    <div class="w-40">

        <x-filament::button
            wire:click="cetak"
            tag="a"
            color="success"
            icon="heroicon-o-printer"
        >
            Print
        </x-filament::button>
    </div>
</x-filament-panels::page>
