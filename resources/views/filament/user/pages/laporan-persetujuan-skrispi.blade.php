<x-filament-panels::page>
    @php
        if ($record === null) {
            redirect()->route('filament.user.pages.dashboard');
        }
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 font-sans">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Informasi Judul Card --}}
            <x-filament::card>
                <x-slot name="header">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary-50 dark:bg-gray-700 rounded-lg">
                            <x-heroicon-o-document-text class="w-6 h-6 text-primary-600 dark:text-primary-400" />
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                            Informasi Judul
                        </h2>
                    </div>
                </x-slot>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Judul Skripsi / Tugas Akhir
                        </h3>
                        <p class="mt-2 text-lg font-semibold text-gray-800 dark:text-gray-200 leading-relaxed">
                            {{ $record->judul ?? '-' }}
                        </p>
                    </div>

                </div>
            </x-filament::card>

            {{-- Dosen Pembimbing & Penguji Card --}}
            <x-filament::card>
                <x-slot name="header">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary-50 dark:bg-gray-700 rounded-lg">
                            <x-heroicon-o-user-group class="w-6 h-6 text-primary-600 dark:text-primary-400" />
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                            Dosen Pembimbing & Penguji
                        </h2>
                    </div>
                </x-slot>

                <div class="space-y-8">
                    {{-- Pembimbing --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">Pembimbing</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Pembimbing I</p>
                                <p class="mt-1 text-base font-bold text-gray-900 dark:text-white">{{ $record->pembimbingSatu->nama?? 'Belum ditentukan' }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Pembimbing II</p>
                                <p class="mt-1 text-base font-bold text-gray-900 dark:text-white">{{ $record->pembimbingDua->nama ?? 'Belum ditentukan' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Penguji --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">Penguji</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Penguji I</p>
                                <p class="mt-1 text-base font-bold text-gray-900 dark:text-white">{{ $record->pengujiSatu->nama ?? 'Belum ditentukan' }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Penguji II</p>
                                <p class="mt-1 text-base font-bold text-gray-900 dark:text-white">{{ $record->pengujiDua->nama ?? 'Belum ditentukan' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-filament::card>

        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Data Mahasiswa Card --}}
            <x-filament::card>
                <x-slot name="header">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary-50 dark:bg-gray-700 rounded-lg">
                            <x-heroicon-o-user-circle class="w-6 h-6 text-primary-600 dark:text-primary-400" />
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                            Data Mahasiswa
                        </h2>
                    </div>
                </x-slot>
                <dl class="space-y-4">
                    <div class="flex flex-col">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Mahasiswa</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ $record->mahasiswa->nama }}</dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NPM</dt>
                        <dd class="mt-1 text-base font-mono text-primary-600 dark:text-primary-400">{{ $record->mahasiswa->npm }}</dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor HP</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ $record->mahasiswa->nomor_hp }}</dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Agama</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ $record->mahasiswa->agama }}</dd>
                    </div>
                </dl>
            </x-filament::card>

            {{-- Timeline Card --}}
            <x-filament::card>
                <x-slot name="header">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary-50 dark:bg-gray-700 rounded-lg">
                            <x-heroicon-o-clock class="w-6 h-6 text-primary-600 dark:text-primary-400" />
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                            Timeline
                        </h2>
                    </div>
                </x-slot>
                <div class="space-y-6">
                    <div class="flex">
                        <div class="flex flex-col items-center mr-4">
                            <div>
                                <div class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-full">
                                    <x-heroicon-s-calendar class="w-5 h-5 text-white" />
                                </div>
                            </div>
                            <div class="w-px h-full bg-gray-300 dark:bg-gray-600"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pengajuan</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $record->created_at->format('d F Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $record->created_at->format('H:i') }} WIB</p>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex flex-col items-center mr-4">
                            <div>
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-500 rounded-full">
                                    <x-heroicon-s-arrow-path class="w-5 h-5 text-white" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diperbarui</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $record->updated_at->diffForHumans() }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $record->updated_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>
            </x-filament::card>

        </div>

    </div>
</x-filament-panels::page>
