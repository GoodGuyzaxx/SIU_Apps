<x-filament-panels::page>

    {{-- ==============================
         CONNECTION STATUS CARD
    ============================== --}}
    <div class="space-y-6">

        {{-- Status Panel --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-700 dark:to-emerald-800">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-xl">
                        <x-heroicon-o-signal class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Status Koneksi WhatsApp</h2>
                        <p class="text-sm text-green-100">GOWA API — go-whatsapp-web-multidevice</p>
                    </div>
                </div>

                @if($lastChecked)
                    <span class="text-xs text-green-100 bg-white/10 px-3 py-1 rounded-full">
                        Dicek: {{ $lastChecked }}
                    </span>
                @endif
            </div>

            {{-- Status Content --}}
            <div class="p-6">
                @if($connectionStatus === null)
                    {{-- Empty state --}}
                    <div class="flex flex-col items-center justify-center py-10 gap-3 text-gray-400 dark:text-gray-500">
                        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <x-heroicon-o-wifi class="w-10 h-10" />
                        </div>
                        <p class="text-sm font-medium">Belum ada data status.</p>
                        <p class="text-xs text-center max-w-xs">
                            Klik tombol <strong>Cek Status Koneksi</strong> di pojok kanan atas untuk memeriksa koneksi WhatsApp Gateway.
                        </p>
                    </div>
                @else
                    {{-- Status Cards Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                        {{-- Connected Status --}}
                        <div class="relative flex items-center gap-4 rounded-xl px-5 py-4 border
                            {{ $connectionStatus['is_connected']
                                ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-700'
                                : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-700' }}
                        ">
                            <div class="flex-shrink-0 p-2 rounded-full
                                {{ $connectionStatus['is_connected'] ? 'bg-green-100 dark:bg-green-800' : 'bg-red-100 dark:bg-red-800' }}">
                                @if($connectionStatus['is_connected'])
                                    <x-heroicon-s-check-circle class="w-6 h-6 text-green-600 dark:text-green-400" />
                                @else
                                    <x-heroicon-s-x-circle class="w-6 h-6 text-red-600 dark:text-red-400" />
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Koneksi</p>
                                <p class="text-base font-bold
                                    {{ $connectionStatus['is_connected'] ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">
                                    {{ $connectionStatus['is_connected'] ? 'Terhubung' : 'Terputus' }}
                                </p>
                            </div>
                            {{-- Pulse indicator --}}
                            @if($connectionStatus['is_connected'])
                                <span class="absolute top-3 right-3 flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                                </span>
                            @endif
                        </div>

                        {{-- Logged In Status --}}
                        <div class="flex items-center gap-4 rounded-xl px-5 py-4 border
                            {{ $connectionStatus['is_logged_in']
                                ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-700'
                                : 'bg-orange-50 dark:bg-orange-900/20 border-orange-200 dark:border-orange-700' }}
                        ">
                            <div class="flex-shrink-0 p-2 rounded-full
                                {{ $connectionStatus['is_logged_in'] ? 'bg-blue-100 dark:bg-blue-800' : 'bg-orange-100 dark:bg-orange-800' }}">
                                @if($connectionStatus['is_logged_in'])
                                    <x-heroicon-s-user-circle class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                                @else
                                    <x-heroicon-o-user-circle class="w-6 h-6 text-orange-600 dark:text-orange-400" />
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Login</p>
                                <p class="text-base font-bold
                                    {{ $connectionStatus['is_logged_in'] ? 'text-blue-700 dark:text-blue-300' : 'text-orange-700 dark:text-orange-300' }}">
                                    {{ $connectionStatus['is_logged_in'] ? 'Sudah Login' : 'Belum Login' }}
                                </p>
                            </div>
                        </div>

                        {{-- Device ID --}}
                        <div class="flex items-center gap-4 rounded-xl px-5 py-4 border
                            bg-purple-50 dark:bg-purple-900/20 border-purple-200 dark:border-purple-700">
                            <div class="flex-shrink-0 p-2 rounded-full bg-purple-100 dark:bg-purple-800">
                                <x-heroicon-o-device-phone-mobile class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Device ID</p>
                                <p class="text-sm font-bold text-purple-700 dark:text-purple-300 truncate" title="{{ $connectionStatus['device_id'] }}">
                                    {{ $connectionStatus['device_id'] }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Response Detail --}}
                    <div class="mt-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                @if($connectionStatus['success'])
                                    <x-heroicon-s-check-badge class="w-5 h-5 text-green-500" />
                                @else
                                    <x-heroicon-s-exclamation-circle class="w-5 h-5 text-red-500" />
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">HTTP Status:</span>
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-md
                                        {{ $connectionStatus['success'] ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ $connectionStatus['http_code'] }}
                                    </span>
                                    @if($connectionStatus['code'])
                                        <span class="text-xs font-bold px-2 py-0.5 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $connectionStatus['code'] }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $connectionStatus['message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ==============================
             ADD DEVICE & QR CODE ROW
        ============================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- ADD DEVICE PANEL --}}
            <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex items-center gap-3 px-6 py-4 bg-gradient-to-r from-indigo-500 to-violet-600 dark:from-indigo-700 dark:to-violet-800">
                    <div class="p-2 bg-white/20 rounded-xl">
                        <x-heroicon-o-plus-circle class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-white">Tambah Device</h2>
                        <p class="text-xs text-indigo-100">Daftarkan device baru ke GOWA API</p>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Input + Button --}}
                    <div>
                        <label for="new-device-id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Device ID
                        </label>
                        <div class="flex gap-3">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <x-heroicon-o-device-phone-mobile class="w-4 h-4 text-gray-400" />
                                </div>
                                <input
                                    id="new-device-id"
                                    type="text"
                                    wire:model="new_device_id"
                                    placeholder="my-custom-device-id"
                                    class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                />
                            </div>
                            <x-filament::button
                                wire:click="addDevice"
                                color="primary"
                                icon="heroicon-o-plus"
                                size="md"
                            >
                                Tambah
                            </x-filament::button>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                            Masukkan ID unik untuk perangkat baru. Contoh: <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">device-kantor</code>
                        </p>
                    </div>

                    {{-- Result --}}
                    @if($addDeviceResult)
                        <div class="rounded-xl border p-4 transition-all duration-300
                            {{ $addDeviceResult['success']
                                ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-700'
                                : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-700' }}
                        ">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-start gap-3">
                                    @if($addDeviceResult['success'])
                                        <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                                    @else
                                        <x-heroicon-s-x-circle class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" />
                                    @endif
                                    <div class="space-y-1">
                                        <p class="text-sm font-semibold {{ $addDeviceResult['success'] ? 'text-green-800 dark:text-green-200' : 'text-red-800 dark:text-red-200' }}">
                                            {{ $addDeviceResult['message'] }}
                                        </p>
                                        <span class="inline-flex text-xs font-bold px-2 py-0.5 rounded-md
                                            {{ $addDeviceResult['success'] ? 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-300' }}">
                                            {{ $addDeviceResult['code'] }}
                                        </span>

                                        {{-- Device details on success --}}
                                        @if($addDeviceResult['success'] && $addDeviceResult['device'])
                                            <div class="mt-2 grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-gray-600 dark:text-gray-400">
                                                <span class="font-medium">ID:</span>
                                                <span class="font-mono">{{ $addDeviceResult['device']['id'] ?? '-' }}</span>
                                                <span class="font-medium">State:</span>
                                                <span>
                                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-xs font-semibold
                                                        {{ ($addDeviceResult['device']['state'] ?? '') === 'connected' ? 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-300' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                                        {{ $addDeviceResult['device']['state'] ?? '-' }}
                                                    </span>
                                                </span>
                                                @if(!empty($addDeviceResult['device']['phone_number']))
                                                    <span class="font-medium">Phone:</span>
                                                    <span class="font-mono">{{ $addDeviceResult['device']['phone_number'] }}</span>
                                                @endif
                                                @if(!empty($addDeviceResult['device']['created_at']))
                                                    <span class="font-medium">Created:</span>
                                                    <span>{{ $addDeviceResult['device']['created_at'] }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <button wire:click="dismissAddDeviceResult" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors p-1">
                                    <x-heroicon-o-x-mark class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- QR CODE LOGIN PANEL --}}
            <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex items-center gap-3 px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-600 dark:from-amber-700 dark:to-orange-800">
                    <div class="p-2 bg-white/20 rounded-xl">
                        <x-heroicon-o-qr-code class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-white">Login QR Code</h2>
                        <p class="text-xs text-amber-100">Scan untuk menghubungkan WhatsApp</p>
                    </div>
                </div>

                <div class="p-6">
                    @if($qrCodeData === null)
                        {{-- Empty state --}}
                        <div class="flex flex-col items-center justify-center py-8 gap-3 text-gray-400 dark:text-gray-500">
                            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-2xl">
                                <x-heroicon-o-qr-code class="w-12 h-12" />
                            </div>
                            <p class="text-sm font-medium">Belum ada QR Code.</p>
                            <p class="text-xs text-center max-w-xs">
                                Klik tombol di bawah atau <strong>Login QR Code</strong> di header untuk generate QR Code login.
                            </p>
                            <x-filament::button
                                wire:click="loginWithQrCode"
                                color="warning"
                                icon="heroicon-o-qr-code"
                                size="md"
                                class="mt-2"
                            >
                                Generate QR Code
                            </x-filament::button>
                        </div>
                    @elseif($qrCodeData['success'] && $qrCodeData['qr_link'])
                        {{-- QR Code Display --}}
                        <div class="flex flex-col items-center gap-4">
                            {{-- QR Image --}}
                            <div class="relative p-3 bg-white rounded-2xl shadow-lg border-2 border-dashed border-green-300 dark:border-green-600">
                                <img
                                    src="{{ $qrCodeData['qr_link'] }}"
                                    alt="WhatsApp QR Code"
                                    class="w-56 h-56 object-contain rounded-xl"
                                    loading="eager"
                                />
                                {{-- Countdown overlay --}}
                                <div class="absolute -top-2 -right-2 bg-amber-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-md">
                                    {{ $qrCodeData['qr_duration'] }}s
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="text-center space-y-1.5">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    Scan QR Code dengan WhatsApp
                                </p>
                                <div class="flex items-center justify-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <x-heroicon-o-device-phone-mobile class="w-3.5 h-3.5" />
                                    <span>Device: <strong>{{ $qrCodeData['device_id'] }}</strong></span>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <x-heroicon-o-clock class="w-3.5 h-3.5" />
                                    <span>{{ $qrCodeData['fetched_at'] }}</span>
                                </div>
                            </div>

                            {{-- Steps --}}
                            <div class="w-full rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 p-4">
                                <p class="text-xs font-semibold text-amber-800 dark:text-amber-200 mb-2">Cara Login:</p>
                                <ol class="text-xs text-amber-700 dark:text-amber-300 space-y-1 list-decimal list-inside">
                                    <li>Buka <strong>WhatsApp</strong> di HP Anda</li>
                                    <li>Ketuk <strong>Menu (⋮)</strong> → <strong>Linked Devices</strong></li>
                                    <li>Ketuk <strong>Link a Device</strong></li>
                                    <li>Arahkan kamera ke QR Code di atas</li>
                                </ol>
                            </div>

                            {{-- Action buttons --}}
                            <div class="flex items-center gap-3">
                                <x-filament::button
                                    wire:click="refreshQrCode"
                                    color="warning"
                                    icon="heroicon-o-arrow-path"
                                    size="sm"
                                    outlined
                                >
                                    Refresh QR
                                </x-filament::button>
                                <x-filament::button
                                    wire:click="dismissQrCode"
                                    color="gray"
                                    icon="heroicon-o-x-mark"
                                    size="sm"
                                    outlined
                                >
                                    Tutup
                                </x-filament::button>
                            </div>
                        </div>
                    @else
                        {{-- Error state --}}
                        <div class="flex flex-col items-center justify-center py-8 gap-3">
                            <div class="p-4 bg-red-100 dark:bg-red-900/30 rounded-2xl">
                                <x-heroicon-o-exclamation-triangle class="w-10 h-10 text-red-500" />
                            </div>
                            <p class="text-sm font-semibold text-red-700 dark:text-red-300">
                                Gagal Mengambil QR Code
                            </p>
                            <p class="text-xs text-center max-w-xs text-gray-500 dark:text-gray-400">
                                {{ $qrCodeData['message'] }}
                            </p>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <x-heroicon-o-device-phone-mobile class="w-3.5 h-3.5" />
                                <span>Device: {{ $qrCodeData['device_id'] }}</span>
                            </div>
                            <div class="flex items-center gap-3 mt-2">
                                <x-filament::button
                                    wire:click="loginWithQrCode"
                                    color="warning"
                                    icon="heroicon-o-arrow-path"
                                    size="sm"
                                >
                                    Coba Lagi
                                </x-filament::button>
                                <x-filament::button
                                    wire:click="dismissQrCode"
                                    color="gray"
                                    icon="heroicon-o-x-mark"
                                    size="sm"
                                    outlined
                                >
                                    Tutup
                                </x-filament::button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- ==============================
             CONFIGURATION FORM
        ============================== --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30">
                <div class="p-2 bg-amber-100 dark:bg-amber-900/40 rounded-xl">
                    <x-heroicon-o-cog-6-tooth class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900 dark:text-white">Konfigurasi API</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Pengaturan disimpan langsung ke file <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">.env</code></p>
                </div>
            </div>

            <div class="p-6">
                {{ $this->configForm }}

                {{-- Info Box --}}
                <div class="mt-6 flex gap-3 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 p-4">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" />
                    <div class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                        <p class="font-semibold">Catatan Konfigurasi</p>
                        <ul class="list-disc list-inside space-y-0.5 text-xs">
                            <li><strong>Base URL</strong> digunakan untuk endpoint cek status (<code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">/app/status</code>), tambah device (<code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">/devices</code>), dan login QR (<code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">/app/login</code>).</li>
                            <li><strong>Send Link Endpoint</strong> adalah URL lengkap yang digunakan saat mengirim pesan WhatsApp.</li>
                            <li><strong>Device ID</strong> digunakan sebagai header <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">X-Device-Id</code> saat login QR Code.</li>
                            <li>Klik <strong>Simpan Konfigurasi</strong> akan memperbarui file <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">.env</code> dan membersihkan cache.</li>
                        </ul>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-6 flex items-center gap-3 justify-end flex-wrap">
                    <x-filament::button
                        wire:click="checkConnectionStatus"
                        color="info"
                        icon="heroicon-o-signal"
                        size="md"
                    >
                        Cek Status Koneksi
                    </x-filament::button>

                    <x-filament::button
                        wire:click="saveConfiguration"
                        color="success"
                        icon="heroicon-o-check-circle"
                        size="md"
                    >
                        Simpan Konfigurasi
                    </x-filament::button>
                </div>
            </div>
        </div>

    </div>

</x-filament-panels::page>
