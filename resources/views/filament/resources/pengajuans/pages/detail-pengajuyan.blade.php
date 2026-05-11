<x-filament-panels::page>
<div class="space-y-6 pb-8">

    {{-- ===== STATUS BANNER ===== --}}
    @php
        $statusColor = match($record->status) {
            'Disetujui' => ['bg' => 'bg-success-50 dark:bg-success-950', 'border' => 'border-success-300 dark:border-success-700', 'icon_bg' => 'bg-success-100 dark:bg-success-900', 'icon' => 'text-success-600 dark:text-success-400', 'text' => 'text-success-800 dark:text-success-200', 'sub' => 'text-success-600 dark:text-success-400'],
            'Ditolak'   => ['bg' => 'bg-danger-50 dark:bg-danger-950',   'border' => 'border-danger-300 dark:border-danger-700',   'icon_bg' => 'bg-danger-100 dark:bg-danger-900',   'icon' => 'text-danger-600 dark:text-danger-400',   'text' => 'text-danger-800 dark:text-danger-200',   'sub' => 'text-danger-600 dark:text-danger-400'],
            default     => ['bg' => 'bg-warning-50 dark:bg-warning-950', 'border' => 'border-warning-300 dark:border-warning-700', 'icon_bg' => 'bg-warning-100 dark:bg-warning-900', 'icon' => 'text-warning-600 dark:text-warning-400', 'text' => 'text-warning-800 dark:text-warning-200', 'sub' => 'text-warning-600 dark:text-warning-400'],
        };
        $statusLabel = match($record->status) {
            'Disetujui' => 'Pengajuan Disetujui',
            'Ditolak'   => 'Pengajuan Ditolak',
            default     => 'Menunggu Keputusan',
        };
        $statusSub = match($record->status) {
            'Disetujui' => 'Judul skripsi mahasiswa ini telah disetujui dan data judul telah dibuat.',
            'Ditolak'   => 'Pengajuan ini ditolak. Lihat catatan penolakan di bawah.',
            default     => 'Pengajuan ini sedang menunggu review dari program studi.',
        };
    @endphp

    <div class="rounded-xl border {{ $statusColor['border'] }} {{ $statusColor['bg'] }} px-5 py-4 flex items-start gap-4">
        <div class="flex-shrink-0 rounded-full p-2 {{ $statusColor['icon_bg'] }}">
            @if($record->status === 'Disetujui')
                <x-heroicon-o-check-circle class="h-6 w-6 {{ $statusColor['icon'] }}" />
            @elseif($record->status === 'Ditolak')
                <x-heroicon-o-x-circle class="h-6 w-6 {{ $statusColor['icon'] }}" />
            @else
                <x-heroicon-o-clock class="h-6 w-6 {{ $statusColor['icon'] }}" />
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold {{ $statusColor['text'] }}">{{ $statusLabel }}</p>
            <p class="mt-0.5 text-xs {{ $statusColor['sub'] }}">{{ $statusSub }}</p>
        </div>
        <span class="flex-shrink-0 text-xs font-medium px-2.5 py-1 rounded-full border {{ $statusColor['border'] }} {{ $statusColor['text'] }} {{ $statusColor['icon_bg'] }}">
            {{ $record->status }}
        </span>
    </div>

    {{-- ===== CATATAN PENOLAKAN (only when Ditolak) ===== --}}
    @if($record->status === 'Ditolak' && $record->catatan)
        <div class="rounded-xl border border-danger-200 dark:border-danger-800 bg-danger-50 dark:bg-danger-950 p-5">
            <div class="flex items-center gap-2 mb-2">
                <x-heroicon-o-exclamation-triangle class="h-4 w-4 text-danger-600 dark:text-danger-400" />
                <h3 class="text-sm font-semibold text-danger-800 dark:text-danger-200">Catatan Penolakan</h3>
            </div>
            <p class="text-sm text-danger-700 dark:text-danger-300 leading-relaxed">{{ $record->catatan }}</p>
        </div>
    @endif

    {{-- ===== MAIN GRID ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Data Mahasiswa --}}
        <div class="lg:col-span-1 space-y-4">

            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2">
                    <x-heroicon-o-user-circle class="h-4 w-4 text-primary-500" />
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Data Mahasiswa</h3>
                </div>
                <div class="px-5 py-4 space-y-4">
                    <div>
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Nama Lengkap</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $record->mahasiswa->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">NPM</p>
                        <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300">
                            {{ $record->mahasiswa->npm }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Program Studi</p>
                        <p class="mt-1 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $record->mahasiswa->prodi->nama_prodi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jenjang</p>
                        <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-info-100 dark:bg-info-900 text-info-700 dark:text-info-300">
                            {{ $record->mahasiswa->jenjang ?? '-' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Nomor HP</p>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                            <x-heroicon-o-phone class="h-3.5 w-3.5 text-green-500" />
                            {{ $record->mahasiswa->nomor_hp }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Agama</p>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ $record->mahasiswa->agama }}</p>
                    </div>
                </div>
            </div>

            {{-- Waktu --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2">
                    <x-heroicon-o-calendar-days class="h-4 w-4 text-primary-500" />
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Waktu</h3>
                </div>
                <div class="px-5 py-4 space-y-4">
                    <div>
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</p>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($record->created_at)->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Terakhir Diperbarui</p>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($record->updated_at)->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT: Judul Proposals --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Minat Kekhususan --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm px-5 py-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Minat / Kekhususan</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $record->minat_kekuhusan }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-warning-100 dark:bg-warning-900 text-warning-700 dark:text-warning-300 border border-warning-200 dark:border-warning-700">
                    Peminatan
                </span>
            </div>

            {{-- Judul Cards --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2">
                    <x-heroicon-o-document-text class="h-4 w-4 text-primary-500" />
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Judul yang Diajukan</h3>
                    <span class="ml-auto text-xs text-gray-400 dark:text-gray-500">3 pilihan</span>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach([
                        ['num' => 1, 'color' => 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300',   'judul' => $record->judul_satu],
                        ['num' => 2, 'color' => 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300', 'judul' => $record->judul_dua],
                        ['num' => 3, 'color' => 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300','judul' => $record->judul_tiga],
                    ] as $item)
                        <div class="px-5 py-4 flex items-start gap-4">
                            <span class="flex-shrink-0 inline-flex items-center justify-center h-7 w-7 rounded-full text-xs font-bold {{ $item['color'] }}">
                                {{ $item['num'] }}
                            </span>
                            <p class="text-sm text-gray-800 dark:text-gray-200 leading-relaxed flex-1">
                                {{ $item['judul'] ?? '-' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Catatan (non-rejection / general note) --}}
            @if($record->catatan && $record->status !== 'Ditolak')
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2">
                        <x-heroicon-o-chat-bubble-left-ellipsis class="h-4 w-4 text-gray-400" />
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Catatan</h3>
                    </div>
                    <div class="px-5 py-4">
                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $record->catatan }}</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- ===== ACTION BAR (only when Pengajuan/pending) ===== --}}
    @if($record->status === 'Pengajuan')
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm px-5 py-4">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Tindakan</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Setujui atau tolak pengajuan ini</p>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Edit --}}
                    <button
                        type="button"
                        wire:click="editPengajuan({{ $record->id }})"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                    >
                        <x-heroicon-o-pencil-square class="h-4 w-4" />
                        Edit
                    </button>

                    {{-- Tolak --}}
                    <button
                        type="button"
                        x-data
                        x-on:click="$dispatch('open-modal', { id: 'customForm' })"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-danger-600 hover:bg-danger-700 focus:outline-none focus:ring-2 focus:ring-danger-500 transition-colors"
                    >
                        <x-heroicon-o-x-circle class="h-4 w-4" />
                        Tolak
                    </button>

                    {{-- Setujui --}}
                    <button
                        type="button"
                        x-data
                        x-on:click="$dispatch('open-modal', { id: 'approveModal' })"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-success-600 hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-success-500 transition-colors"
                    >
                        <x-heroicon-o-check-circle class="h-4 w-4" />
                        Setujui
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>

{{-- ===== MODAL: TOLAK ===== --}}
<x-filament::modal id="customForm" width="2xl">
    <x-slot name="heading">
        <div class="flex items-center gap-2">
            <x-filament::icon icon="heroicon-o-x-circle" class="h-5 w-5 text-danger-600" />
            <span>Tolak Pengajuan Judul</span>
        </div>
    </x-slot>

    <div class="space-y-3">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Berikan alasan penolakan yang jelas agar mahasiswa dapat memperbaiki pengajuannya.
        </p>
        {{ $this->rejectForm }}
    </div>

    <x-slot name="footerActions">
        <x-filament::button
            color="gray"
            x-on:click="$dispatch('close-modal', { id: 'customForm' })"
        >
            Batal
        </x-filament::button>
        <x-filament::button
            color="danger"
            wire:click="reject"
            icon="heroicon-o-x-circle"
        >
            Tolak Pengajuan
        </x-filament::button>
    </x-slot>
</x-filament::modal>

{{-- ===== MODAL: SETUJUI ===== --}}
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
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Pilih judul yang disetujui, lalu lengkapi informasi pembimbing dan penguji.
        </p>

        <x-filament::input.wrapper label="Pilih Judul yang Disetujui">
            <x-filament::input.select wire:model="judul" required>
                <option value="">— Pilih Judul —</option>
                <option value="{{ $this->record->judul_satu }}">Pilihan 1: {{ \Str::limit($this->record->judul_satu, 80) }}</option>
                <option value="{{ $this->record->judul_dua }}">Pilihan 2: {{ \Str::limit($this->record->judul_dua, 80) }}</option>
                <option value="{{ $this->record->judul_tiga }}">Pilihan 3: {{ \Str::limit($this->record->judul_tiga, 80) }}</option>
            </x-filament::input.select>
        </x-filament::input.wrapper>

        @error('judul')
            <p class="text-danger-600 text-sm">{{ $message }}</p>
        @enderror

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
            Setujui & Simpan
        </x-filament::button>
    </x-slot>
</x-filament::modal>

</x-filament-panels::page>
