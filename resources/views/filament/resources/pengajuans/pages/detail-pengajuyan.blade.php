<x-filament-panels::page>
    <div class="p-6">
        {{-- Header Section --}}
        <div class="mb-6">
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Status: <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                {{ $record->status }}
            </span>
            </p>
        </div>

        {{-- Data Mahasiswa Card --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Data Mahasiswa
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Mahasiswa --}}
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Nama Lengkap
                        </h4>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">
                            {{ $record->mahasiswa->nama }}
                        </p>
                    </div>

                    {{-- NPM --}}
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            NPM
                        </h4>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">
                            {{ $record->mahasiswa->npm }}
                        </p>
                    </div>

                    {{-- Nomor HP --}}
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Nomor HP
                        </h4>
                        <p class="text-base text-gray-900 dark:text-white flex items-center">
                            <svg class="h-4 w-4 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $record->mahasiswa->nomor_hp }}
                        </p>
                    </div>

                    {{-- Agama --}}
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Agama
                        </h4>
                        <p class="text-base text-gray-900 dark:text-white">
                            {{ $record->mahasiswa->agama }}
                        </p>
                    </div>
                </div>
            </div>
        </div>


        {{-- Main Content Card --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            {{-- Informasi Pengajuan --}}
            <div class="p-6 space-y-6">
                {{-- Minat Kekhususan --}}
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                        Minat Kekhususan
                    </h3>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $record->minat_kekuhusan }}
                    </p>
                </div>

                {{-- Judul-judul yang Diajukan --}}
                <div class="space-y-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Judul yang Diajukan
                    </h3>

                    {{-- Judul 1 --}}
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                        <div class="flex items-start">
                        <span class="flex-shrink-0 inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-sm font-medium">
                            1
                        </span>
                            <p class="ml-3 text-sm text-gray-900 dark:text-white leading-relaxed">
                                {{ $record->judul_satu }}
                            </p>
                        </div>
                    </div>

                    {{-- Judul 2 --}}
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                        <div class="flex items-start">
                        <span class="flex-shrink-0 inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-sm font-medium">
                            2
                        </span>
                            <p class="ml-3 text-sm text-gray-900 dark:text-white leading-relaxed">
                                {{ $record->judul_dua }}
                            </p>
                        </div>
                    </div>

                    {{-- Judul 3 --}}
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                        <div class="flex items-start">
                        <span class="flex-shrink-0 inline-flex items-center justify-center h-8 w-8 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 text-sm font-medium">
                            3
                        </span>
                            <p class="ml-3 text-sm text-gray-900 dark:text-white leading-relaxed">
                                {{ $record->judul_tiga }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Catatan (if exists) --}}
                @if($record->catatan)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                            Catatan
                        </h3>
                        <p class="text-sm text-gray-900 dark:text-white">
                            {{ $record->catatan }}
                        </p>
                    </div>
                @endif

                {{-- Informasi Waktu --}}
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Tanggal Pengajuan
                            </h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($record->created_at)->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Terakhir Diperbarui
                            </h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($record->updated_at)->format('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4">
                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    {{-- Edit Button --}}
                    <button
                        type="button"
                        wire:click="editPengajuan({{ $record->id }})"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                    >
                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </button>

                    {{-- Tolak Button --}}
                    <a
                        x-data
                        x-on:click.prevent="$dispatch('open-modal', { id: 'customForm' })"
                        id="customForm"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                    >
                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Tolak
                    </a>

                    {{-- Setujui Button --}}
                    <a
                        x-data
                        x-on:click.prevent="$dispatch('open-modal', { id: 'approveModal' })"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                    >
                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Setujui
                    </a>

{{--                    <a--}}
{{--                        x-data--}}
{{--                        x-on:click.prevent="$dispatch('open-modal', { id: 'approveModal' })"--}}
{{--                        class="inline-flex items-center justify-center font-medium tracking-tight rounded-lg focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 h-9 px-4 text-white shadow focus:ring-white cursor-pointer">--}}
{{--                        Open your custom modal--}}
{{--                    </a>--}}
                </div>
            </div>
        </div>
    </div>

        <x-filament::modal id="customForm" width="5xl">
            <x-slot name="heading">Catatan Alasan Penolakan Pengajuan Judul </x-slot>

                {{$this->rejectForm}}

            <x-filament::button
                wire:click="reject"
                color="danger"
            >
                Tolak
            </x-filament::button>
            <x-slot name="action">

            </x-slot>
        </x-filament::modal>

    {{-- Setujui Pengajuan --}}
    <x-filament::modal
        id="approveModal"
        width="2xl"
        :visible="$this->approveModalOpen ?? null"
        :close-by-clicking-away="true"
        :close-by-pressing-escape="true"
        x-on:close="$wire.closeApproveModal?.()"
    >
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <x-filament::icon icon="heroicon-o-check-badge" class="h-5 w-5 text-success-600" />
                <span>Setujui Pengajuan Judul</span>
            </div>
        </x-slot>

        <div class="space-y-4">
            <p class="text-sm text-gray-500">
                Pilih judul yang disetujui, lalu lengkapi informasi tambahan jika diperlukan.
            </p>

            {{-- Pilih Judul --}}
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model="judul" required>
                    <option value="">— Pilih Judul —</option>
                    <option value="{{ $this->record->judul_satu }}">{{ $this->record->judul_satu }}</option>
                    <option value="{{ $this->record->judul_dua }}">{{ $this->record->judul_dua }}</option>
                    <option value="{{ $this->record->judul_tiga }}">{{ $this->record->judul_tiga }}</option>
                </x-filament::input.select>

                @error('judul')
                <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </x-filament::input.wrapper>

            {{-- Schema form persetujuan (mis. pilih dosen, catatan, dsb.) --}}
            <form wire:submit.prevent="approve" class="space-y-4">
                {{ $this->approveForm }}
            </form>
        </div>

        <x-slot name="footerActions">
            <x-filament::button
                color="gray"
                x-on:click="$dispatch('close-modal', { id: 'approveModal' })"
            >
                Batal
            </x-filament::button>

            <x-filament::button
                color="success"
                wire:click="approve"
                wire:target="approve"
                wire:loading.attr="disabled"
                icon="heroicon-o-check"
            >
                Terima
            </x-filament::button>
        </x-slot>
    </x-filament::modal>


    {{--    <x-filament::modal id="customFormApprove">--}}
{{--        <x-slot name="heading">Catatan Alasan Penolakan Pengajuan Judul </x-slot>--}}

{{--        <x-filament::input.wrapper>--}}
{{--            <x-filament::input.select wire:model="judul">--}}
{{--                <option value="-">Pilih Judul Terlebih Dahulu</option>--}}
{{--                <option value="{{$this->record->judul_satu}}">{{$this->record->judul_satu}}</option>--}}
{{--                <option value="{{$this->record->judul_dua}}">{{$this->record->judul_dua}}</option>--}}
{{--                <option value="{{$this->record->judul_tiga}}">{{$this->record->judul_tiga}}</option>--}}
{{--            </x-filament::input.select>--}}
{{--        </x-filament::input.wrapper>--}}

{{--        {{$this->approveForm}}--}}

{{--        <x-filament::button--}}
{{--            wire:click="approve"--}}
{{--            color="success"--}}
{{--        >--}}
{{--            Terima--}}
{{--        </x-filament::button>--}}
{{--        <x-slot name="action">--}}

{{--        </x-slot>--}}
{{--    </x-filament::modal>--}}




</x-filament-panels::page>
