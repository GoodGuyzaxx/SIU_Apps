{{-- resources/views/filament/user/resources/pengajuan/pages/detail-pengajuan-user.blade.php --}}
<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Hero Header Section --}}
        <div class="relative bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 rounded-2xl shadow-xl overflow-hidden">
            {{-- Decorative background pattern --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
            </div>

            <div class="relative px-8 py-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                @svg('heroicon-o-document-text', 'h-7 w-7 text-white')
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-white">
                                    Pengajuan #{{ $record->id }}
                                </h1>
                                <p class="text-primary-100 text-sm mt-1">
                                    Detail lengkap pengajuan judul Anda
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 mt-4 text-sm text-primary-50">
                            <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                                @svg('heroicon-m-calendar', 'h-4 w-4')
                                <span class="font-medium">Dibuat:</span>
                                <span>{{ \Illuminate\Support\Carbon::parse($record->created_at)->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                                @svg('heroicon-m-arrow-path', 'h-4 w-4')
                                <span class="font-medium">Diperbarui:</span>
                                <span>{{ \Illuminate\Support\Carbon::parse($record->updated_at)->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    @php
                        $status = $record->status;
                        $statusConfig = match ($status) {
                            'Pengajuan' => ['color' => 'warning', 'icon' => 'heroicon-m-clock', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'ring' => 'ring-yellow-400'],
                            'Disetujui' => ['color' => 'success', 'icon' => 'heroicon-m-check-circle', 'bg' => 'bg-green-100', 'text' => 'text-green-800', 'ring' => 'ring-green-400'],
                            'Ditolak'   => ['color' => 'danger', 'icon' => 'heroicon-m-x-circle', 'bg' => 'bg-red-100', 'text' => 'text-red-800', 'ring' => 'ring-red-400'],
                            default     => ['color' => 'gray', 'icon' => 'heroicon-m-question-mark-circle', 'bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'ring' => 'ring-gray-400'],
                        };
                    @endphp

                    <div class="flex flex-col items-start md:items-end gap-2">
                        <span class="text-xs font-semibold text-primary-100 uppercase tracking-wider">Status Pengajuan</span>
                        <div class="inline-flex items-center gap-2 px-5 py-3 rounded-xl {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} ring-2 {{ $statusConfig['ring'] }} shadow-lg font-bold text-base">
                            @svg($statusConfig['icon'], 'h-5 w-5')
                            {{ $status }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column - Data Pengajuan --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Minat Kekhususan Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-300">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                                @svg('heroicon-o-academic-cap', 'h-6 w-6 text-white')
                            </div>
                            <h3 class="text-xl font-bold text-white">Minat Kekhususan</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="bg-gradient-to-br from-purple-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-5 border-l-4 border-purple-500">
                            <p class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ $record->minat_kekuhusan ?? 'Belum ditentukan' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Judul-judul yang Diajukan --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-300">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                                    @svg('heroicon-o-document-text', 'h-6 w-6 text-white')
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Judul yang Diajukan</h3>
                                    <p class="text-indigo-100 text-sm">Tiga opsi judul yang telah Anda ajukan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        {{-- Judul 1 --}}
                        <div class="group relative bg-gradient-to-br from-emerald-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-xl p-5 border-l-4 border-emerald-500 hover:shadow-lg transition-all duration-300">
                            @if($record->status === 'Disetujui' && $record->judul === $record->judul_satu)
                                <div class="absolute -top-2 -right-2 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg flex items-center gap-1">
                                    @svg('heroicon-m-check-badge', 'h-4 w-4')
                                    Dipilih
                                </div>
                            @endif
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <span class="text-xl font-bold text-white">1</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-2 block">
                                        Judul Pertama
                                    </label>
                                    <p class="text-base font-medium text-gray-900 dark:text-white leading-relaxed">
                                        {{ $record->judul_satu ?? 'Belum diisi' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Judul 2 --}}
                        <div class="group relative bg-gradient-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-xl p-5 border-l-4 border-blue-500 hover:shadow-lg transition-all duration-300">
                            @if($record->status === 'Disetujui' && $record->judul === $record->judul_dua)
                                <div class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg flex items-center gap-1">
                                    @svg('heroicon-m-check-badge', 'h-4 w-4')
                                    Dipilih
                                </div>
                            @endif
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <span class="text-xl font-bold text-white">2</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-2 block">
                                        Judul Kedua
                                    </label>
                                    <p class="text-base font-medium text-gray-900 dark:text-white leading-relaxed">
                                        {{ $record->judul_dua ?? 'Belum diisi' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Judul 3 --}}
                        <div class="group relative bg-gradient-to-br from-purple-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-xl p-5 border-l-4 border-purple-500 hover:shadow-lg transition-all duration-300">
                            @if($record->status === 'Disetujui' && $record->judul === $record->judul_tiga)
                                <div class="absolute -top-2 -right-2 bg-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg flex items-center gap-1">
                                    @svg('heroicon-m-check-badge', 'h-4 w-4')
                                    Dipilih
                                </div>
                            @endif
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <span class="text-xl font-bold text-white">3</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-2 block">
                                        Judul Ketiga
                                    </label>
                                    <p class="text-base font-medium text-gray-900 dark:text-white leading-relaxed">
                                        {{ $record->judul_tiga ?? 'Belum diisi' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Catatan / Alasan Penolakan --}}
                @if($record->catatan)
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                                    @svg('heroicon-o-chat-bubble-left-right', 'h-6 w-6 text-white')
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">
                                        {{ $record->status === 'Ditolak' ? 'Alasan Penolakan' : 'Catatan' }}
                                    </h3>
                                    <p class="text-orange-100 text-sm">
                                        {{ $record->status === 'Ditolak' ? 'Informasi mengapa pengajuan ditolak' : 'Catatan tambahan dari admin' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="bg-gradient-to-br from-orange-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-5 border-l-4 border-orange-500">
                                <p class="text-base text-gray-900 dark:text-white leading-relaxed">
                                    {{ $record->catatan }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Right Column - Data Mahasiswa & Summary --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Data Mahasiswa Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-300 sticky top-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                                @svg('heroicon-o-user-circle', 'h-6 w-6 text-white')
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Data Mahasiswa</h3>
                                <p class="text-blue-100 text-sm">Identitas pengaju</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="bg-gradient-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border border-blue-200 dark:border-blue-900">
                            <label class="flex items-center text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-2">
                                @svg('heroicon-m-user', 'h-4 w-4 mr-1.5')
                                Nama Lengkap
                            </label>
                            <p class="text-base font-bold text-gray-900 dark:text-white">
                                {{ $record->mahasiswa->nama ?? '-' }}
                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                            <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">
                                @svg('heroicon-m-identification', 'h-4 w-4 mr-1.5')
                                NPM
                            </label>
                            <p class="text-base font-mono font-bold text-blue-600 dark:text-blue-400 tracking-wider">
                                {{ $record->mahasiswa->npm ?? '-' }}
                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border border-green-200 dark:border-green-900">
                            <label class="flex items-center text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-wider mb-2">
                                @svg('heroicon-m-phone', 'h-4 w-4 mr-1.5')
                                Nomor HP
                            </label>
                            <p class="text-base font-semibold text-gray-900 dark:text-white">
                                {{ $record->mahasiswa->nomor_hp ?? '-' }}
                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border border-purple-200 dark:border-purple-900">
                            <label class="flex items-center text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-2">
                                @svg('heroicon-m-heart', 'h-4 w-4 mr-1.5')
                                Agama
                            </label>
                            <p class="text-base font-semibold text-gray-900 dark:text-white">
                                {{ $record->mahasiswa->agama ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Status Summary Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                                @svg('heroicon-o-information-circle', 'h-6 w-6 text-white')
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Ringkasan</h3>
                                <p class="text-gray-300 text-sm">Status pengajuan Anda</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($record->status === 'Pengajuan')
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 rounded-lg p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        @svg('heroicon-m-clock', 'h-6 w-6 text-yellow-500')
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-semibold text-yellow-800 dark:text-yellow-200 mb-1">
                                            Menunggu Persetujuan
                                        </p>
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                            Pengajuan Anda sedang dalam proses review. Mohon tunggu konfirmasi dari admin.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($record->status === 'Disetujui')
                            <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        @svg('heroicon-m-check-circle', 'h-6 w-6 text-green-500')
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-semibold text-green-800 dark:text-green-200 mb-1">
                                            Pengajuan Disetujui
                                        </p>
                                        <p class="text-sm text-green-700 dark:text-green-300">
                                            Selamat! Pengajuan judul Anda telah disetujui. Silakan lanjutkan ke tahap berikutnya.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($record->status === 'Ditolak')
                            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        @svg('heroicon-m-x-circle', 'h-6 w-6 text-red-500')
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-semibold text-red-800 dark:text-red-200 mb-1">
                                            Pengajuan Ditolak
                                        </p>
                                        <p class="text-sm text-red-700 dark:text-red-300">
                                            Mohon maaf, pengajuan Anda ditolak. Silakan periksa catatan penolakan dan ajukan kembali dengan perbaikan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- Action Footer --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    @svg('heroicon-m-information-circle', 'h-5 w-5 text-gray-400')
                    <span>Butuh bantuan? Hubungi admin program studi</span>
                </div>
                <x-filament::button
                    tag="a"
                    href="{{ url()->previous() }}"
                    icon="heroicon-o-arrow-uturn-left"
                    color="gray"
                    outlined
                >
                    Kembali ke Daftar
                </x-filament::button>
            </div>
        </div>
    </div>
</x-filament-panels::page>
