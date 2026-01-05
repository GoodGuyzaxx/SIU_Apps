<x-filament-panels::page>
    {{-- Page content --}}
    {{$this->infoMahasiswa}}

    {{$this->infoStatusUndangan}}

    {{-- Only show the button if status_ujian is 'draft_uploaded' --}}
    @if($this->undangan->status_ujian == 'dijadwalkan')
        <a
            x-data
            x-on:click.prevent="$dispatch('open-modal', { id: 'uploadCostumeForm' })"
            class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
        >
            <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Konfrimasi Kesiapan
        </a>
    @endif

    <x-filament::modal
        id="uploadCostumeForm"
        width="3xl">

        {{$this->uploadForm}}

        <x-filament::button
            wire:click="konfirmasi"
        >
            Upload
            </x-filamnet::button>

        </x-filament::modal>
</x-filament-panels::page>
