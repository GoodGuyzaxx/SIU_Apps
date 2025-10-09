{{-- resources/views/filament/user/resources/pengajuan/pages/detail-pengajuan-user.blade.php --}}
<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header + status --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">
                    Detail Pengajuan #{{ $record->id }}
                </h1>
                <p class="text-sm text-gray-500">
                    Dibuat: {{ \Illuminate\Support\Carbon::parse($record->created_at)->format('d M Y H:i') }}
                    • Diperbarui: {{ \Illuminate\Support\Carbon::parse($record->updated_at)->format('d M Y H:i') }}
                </p>
            </div>

            @php
                $status = $record->status;
                $statusColor = match ($status) {
                    'Pengajuan' => 'warning',
                    'Disetujui' => 'success',
                    'Ditolak'   => 'danger',
                    default     => 'gray',
                };
            @endphp

            <x-filament::badge :color="$statusColor" class="w-fit">
                {{ $status }}
            </x-filament::badge>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Data Pengajuan (read-only) --}}
            <x-filament::section>
                <x-slot name="heading">Data Pengajuan</x-slot>
                <x-slot name="description">Informasi judul dan minat kekhususan</x-slot>

                <dl class="divide-y divide-gray-100">
                    <div class="py-3 grid grid-cols-4 gap-4">
                        <dt class="text-sm text-gray-500 col-span-1">Minat Kekhususan</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-3">
                            {{ $record->minat_kekuhusan ?? '-' }}
                        </dd>
                    </div>

                    <div class="py-3 grid grid-cols-4 gap-4">
                        <dt class="text-sm text-gray-500 col-span-1">Judul 1</dt>
                        <dd class="text-sm font-medium text-emerald-700 col-span-3">
                            {{ $record->judul_satu ?? '-' }}
                        </dd>
                    </div>

                    <div class="py-3 grid grid-cols-4 gap-4">
                        <dt class="text-sm text-gray-500 col-span-1">Judul 2</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-3">
                            {{ $record->judul_dua ?? '-' }}
                        </dd>
                    </div>

                    <div class="py-3 grid grid-cols-4 gap-4">
                        <dt class="text-sm text-gray-500 col-span-1">Judul 3</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-3">
                            {{ $record->judul_tiga ?? '-' }}
                        </dd>
                    </div>

                    @if($record->catatan)
                        <div class="py-3 grid grid-cols-4 gap-4">
                            <dt class="text-sm text-gray-500 col-span-1">Catatan</dt>
                            <dd class="text-sm font-medium text-gray-900 col-span-3">
                                {{ $record->catatan }}
                            </dd>
                        </div>
                    @endif
                </dl>
            </x-filament::section>

            {{-- Data Mahasiswa (read-only) --}}
            <x-filament::section>
                <x-slot name="heading">Data Mahasiswa</x-slot>
                <x-slot name="description">Identitas pengaju</x-slot>

                <dl class="divide-y divide-gray-100">
                    <div class="py-3 grid grid-cols-4 gap-4">
                        <dt class="text-sm text-gray-500 col-span-1">Nama</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-3">
                            {{ $record->mahasiswa->nama ?? '-' }}
                        </dd>
                    </div>

                    <div class="py-3 grid grid-cols-4 gap-4">
                        <dt class="text-sm text-gray-500 col-span-1">NPM</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-3">
                            {{ $record->mahasiswa->npm ?? '-' }}
                        </dd>
                    </div>

                    <div class="py-3 grid grid-cols-4 gap-4">
                        <dt class="text-sm text-gray-500 col-span-1">Nomor HP</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-3">
                            {{ $record->mahasiswa->nomor_hp ?? '-' }}
                        </dd>
                    </div>

                    <div class="py-3 grid grid-cols-4 gap-4">
                        <dt class="text-sm text-gray-500 col-span-1">Agama</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-3">
                            {{ $record->mahasiswa->agama ?? '-' }}
                        </dd>
                    </div>
                </dl>
            </x-filament::section>
        </div>

        {{-- Info ringkas --}}
        <x-filament::section>
            <x-slot name="heading">Ringkasan</x-slot>
            <div class="text-sm text-gray-600">
                Pengajuan ini berada pada status <span class="font-semibold">{{ $record->status }}</span>.
                @if($record->status === 'Ditolak' && $record->catatan)
                    Alasan penolakan: <span class="font-medium text-gray-900">{{ $record->catatan }}</span>.
                @endif
            </div>
        </x-filament::section>

        {{-- Tombol kembali (opsional, tetap read-only) --}}
        <div class="flex">
            <x-filament::button
                tag="a"
                href="{{ url()->previous() }}"
                icon="heroicon-o-arrow-uturn-left"
                color="gray"
            >
                Kembali
            </x-filament::button>
        </div>
    </div>
</x-filament-panels::page>
