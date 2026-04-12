<x-filament-panels::page>
    <div class="space-y-6 font-sans">

        {{-- Header Section --}}
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                {{-- Left Side --}}
                <div class="flex-1">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary-50 dark:bg-gray-700 rounded-lg">
                            <x-heroicon-o-document-text class="w-7 h-7 text-primary-600 dark:text-primary-400" />
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Pengajuan #{{ $record->id }}
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Detail lengkap pengajuan judul Anda.
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex items-center gap-1.5">
                            <x-heroicon-m-calendar class="w-4 h-4" />
                            <span>Dibuat: {{ $record->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <x-heroicon-m-arrow-path class="w-4 h-4" />
                            <span>Diperbarui: {{ $record->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Status --}}
                <div class="flex flex-col items-start md:items-end gap-2">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pengajuan</span>
                    @php
                        $status = $record->status;
                        $statusConfig = match ($status) {
                            'Pengajuan' => ['color' => 'warning', 'icon' => 'heroicon-m-clock'],
                            'Disetujui' => ['color' => 'success', 'icon' => 'heroicon-m-check-circle'],
                            'Ditolak'   => ['color' => 'danger', 'icon' => 'heroicon-m-x-circle'],
                            default     => ['color' => 'gray', 'icon' => 'heroicon-m-question-mark-circle'],
                        };
                    @endphp
                    <x-filament::badge :color="$statusConfig['color']" :icon="$statusConfig['icon']" size="lg">
                        {{ $status }}
                    </x-filament::badge>
                </div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Judul-judul Card --}}
                <x-filament::card>
                    <x-slot name="header">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Judul yang Diajukan</h2>
                    </x-slot>
                    <div class="space-y-4">
                        @foreach (['satu' => 'Pertama', 'dua' => 'Kedua', 'tiga' => 'Ketiga'] as $key => $label)
                            @php
                                $judulKey = "judul_$key";
                                $judul = $record->$judulKey;
                                $isChosen = $record->status === 'Disetujui' && $record->judul === $judul;
                            @endphp
                            <div @class([
                                'p-4 rounded-lg border',
                                'border-primary-500 bg-primary-50 dark:bg-primary-900/20' => $isChosen,
                                'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800' => !$isChosen,
                            ])>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Judul {{ $label }}</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200">{{ $judul ?? 'Belum diisi' }}</p>
                                    </div>
                                    @if ($isChosen)
                                        <x-filament::badge color="success" icon="heroicon-m-check-badge">
                                            Dipilih
                                        </x-filament::badge>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-filament::card>

                {{-- Minat Kekhususan & Catatan --}}
                <div class="grid grid-cols-1 @if($record->catatan) md:grid-cols-2 @endif gap-6">
                    <x-filament::card class="flex-1">
                        <x-slot name="header">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Minat Kekhususan</h2>
                        </x-slot>
                        <p class="text-base font-semibold text-primary-600 dark:text-primary-400">
                            {{ $record->minat_kekuhusan ?? 'Belum ditentukan' }}
                        </p>
                    </x-filament::card>

                    @if($record->catatan)
                        <x-filament::card class="flex-1">
                            <x-slot name="header">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $record->status === 'Ditolak' ? 'Alasan Penolakan' : 'Catatan' }}
                                </h2>
                            </x-slot>
                            <p class="text-base text-gray-700 dark:text-gray-300">
                                {{ $record->catatan }}
                            </p>
                        </x-filament::card>
                    @endif
                </div>

            </div>

            {{-- Right Column --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Data Mahasiswa Card --}}
                <x-filament::card>
                    <x-slot name="header">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Data Mahasiswa</h2>
                    </x-slot>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ $record->mahasiswa->nama ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NPM</dt>
                            <dd class="mt-1 text-base font-mono text-primary-600 dark:text-primary-400">{{ $record->mahasiswa->npm ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor HP</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ $record->mahasiswa->nomor_hp ?? '-' }}</dd>
                        </div>
                    </dl>
                </x-filament::card>

                {{-- Action Footer --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 text-center sm:text-left">
                            Butuh bantuan? Hubungi admin.
                        </p>
                        <x-filament::button
                            tag="a"
                            href="{{ url()->previous() }}"
                            icon="heroicon-o-arrow-uturn-left"
                            color="gray"
                            outlined
                        >
                            Kembali
                        </x-filament::button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-filament-panels::page>
