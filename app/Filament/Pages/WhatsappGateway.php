<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use UnitEnum;

class WhatsappGateway extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'WhatsApp Gateway';
    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 20;

    protected string $view = 'filament.pages.whatsapp-gateway';

    // Form state
    public ?string $wa_api_base_url = null;
    public ?string $wa_api_link = null;
    public ?string $wa_auth_user = null;
    public ?string $wa_auth_pass = null;
    public ?string $wa_device_id = null;

    // Connection status state
    public ?array $connectionStatus = null;
    public bool $isCheckingStatus = false;
    public ?string $lastChecked = null;

    // Add Device state
    public ?string $new_device_id = null;
    public ?array $addDeviceResult = null;

    // QR Code Login state
    public ?array $qrCodeData = null;

    public static function canAccess(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'akademik']);
    }

    public function mount(): void
    {
        $this->wa_api_base_url = config('gowaapi.base_url') ?? '';
        $this->wa_api_link = config('gowaapi.url') ?? '';
        $this->wa_auth_user = config('gowaapi.user') ?? '';
        $this->wa_auth_pass = config('gowaapi.pass') ?? '';
        $this->wa_device_id = config('gowaapi.device') ?? '';
    }

    // -- Schema --

    public function configForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konfigurasi Endpoint API')
                    ->description('Atur endpoint, kredensial, dan device ID untuk GOWA WhatsApp API.')
                    ->icon('heroicon-o-server')
                    ->schema([
                        Grid::make(1)->schema([
                            TextInput::make('wa_api_base_url')
                                ->label('Base URL API (untuk cek status)')
                                ->placeholder('https://api.example.com')
                                ->prefixIcon('heroicon-o-globe-alt')
                                ->url()
                                ->helperText('Digunakan untuk endpoint /app/status. Contoh: https://api.example.com'),
                            TextInput::make('wa_api_link')
                                ->label('Send Link Endpoint')
                                ->placeholder('https://api.example.com/send/link')
                                ->prefixIcon('heroicon-o-paper-airplane')
                                ->url()
                                ->helperText('Endpoint yang digunakan untuk mengirim pesan dengan link preview.'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('wa_auth_user')
                                ->label('Username / Auth User')
                                ->placeholder('user1')
                                ->prefixIcon('heroicon-o-user')
                                ->required(),
                            TextInput::make('wa_auth_pass')
                                ->label('Password / Auth Pass')
                                ->placeholder('••••••••')
                                ->prefixIcon('heroicon-o-lock-closed')
                                ->password()
                                ->revealable()
                                ->required(),
                        ]),
                        Grid::make(1)->schema([
                            TextInput::make('wa_device_id')
                                ->label('Device ID')
                                ->placeholder('main')
                                ->prefixIcon('heroicon-o-device-phone-mobile')
                                ->helperText('ID perangkat WhatsApp yang terhubung. Default: main'),
                        ]),
                    ]),
            ]);
    }

    // -- Actions --

    protected function getHeaderActions(): array
    {
        return [
            Action::make('checkStatus')
                ->label('Cek Status Koneksi')
                ->icon('heroicon-o-signal')
                ->color('info')
                ->action('checkConnectionStatus'),

            Action::make('loginQr')
                ->label('Login QR Code')
                ->icon('heroicon-o-qr-code')
                ->color('warning')
                ->action('loginWithQrCode'),

            Action::make('saveConfig')
                ->label('Simpan Konfigurasi')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action('saveConfiguration'),
        ];
    }

    // -- Methods --

    public function checkConnectionStatus(): void
    {
        $baseUrl = rtrim($this->wa_api_base_url ?? config('gowaapi.base_url') ?? '', '/');

        if (empty($baseUrl)) {
            Notification::make()
                ->title('Base URL Kosong')
                ->body('Harap isi Base URL API terlebih dahulu sebelum mengecek status koneksi.')
                ->warning()
                ->send();
            return;
        }

        $statusUrl = $baseUrl . '/app/status';

        try {
            $response = Http::withBasicAuth(
                $this->wa_auth_user ?? config('gowaapi.user'),
                $this->wa_auth_pass ?? config('gowaapi.pass')
            )
                ->withHeaders(['Accept' => 'application/json'])
                ->timeout(10)
                ->get($statusUrl);

            $body = $response->json();

            $this->connectionStatus = [
                'http_code'    => $response->status(),
                'success'      => $response->successful(),
                'code'         => $body['code'] ?? null,
                'message'      => $body['message'] ?? 'Tidak ada pesan dari server.',
                'is_connected' => $body['results']['is_connected'] ?? false,
                'is_logged_in' => $body['results']['is_logged_in'] ?? false,
                'device_id'    => $body['results']['device_id'] ?? '-',
            ];

            $this->lastChecked = now()->format('d/m/Y H:i:s');

            Notification::make()
                ->title('Status Berhasil Diambil')
                ->body('Respon dari server: ' . ($body['message'] ?? '-'))
                ->success()
                ->send();

        } catch (\Exception $e) {
            $this->connectionStatus = [
                'http_code'    => 0,
                'success'      => false,
                'code'         => 'ERROR',
                'message'      => $e->getMessage(),
                'is_connected' => false,
                'is_logged_in' => false,
                'device_id'    => '-',
            ];

            $this->lastChecked = now()->format('d/m/Y H:i:s');

            Notification::make()
                ->title('Gagal Menghubungi Server')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function saveConfiguration(): void
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            Notification::make()
                ->title('File .env Tidak Ditemukan')
                ->danger()
                ->send();
            return;
        }

        $envContent = File::get($envPath);

        $updates = [
            'WA_API_BASE_URL' => $this->wa_api_base_url ?? '',
            'WA_API_LINK'     => $this->wa_api_link ?? '',
            'WA_AUTH_USER'    => $this->wa_auth_user ?? '',
            'WA_AUTH_PASS'    => $this->wa_auth_pass ?? '',
            'WA_DEVICE_ID'    => $this->wa_device_id ?? '',
        ];

        foreach ($updates as $key => $value) {
            $escaped = addslashes($value);
            if (preg_match("/^{$key}=/m", $envContent)) {
                // Update existing key
                $envContent = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}=\"{$escaped}\"",
                    $envContent
                );
            } else {
                // Append new key
                $envContent .= "\n{$key}=\"{$escaped}\"";
            }
        }

        File::put($envPath, $envContent);

        // Clear config cache
        Artisan::call('config:clear');

        Notification::make()
            ->title('Konfigurasi Berhasil Disimpan')
            ->body('File .env telah diperbarui dan cache konfigurasi dibersihkan.')
            ->success()
            ->send();
    }

    // -- Add Device --

    public function addDevice(): void
    {
        $baseUrl = rtrim($this->wa_api_base_url ?? config('gowaapi.base_url') ?? '', '/');

        if (empty($baseUrl)) {
            Notification::make()
                ->title('Base URL Kosong')
                ->body('Harap isi Base URL API terlebih dahulu.')
                ->warning()
                ->send();
            return;
        }

        $deviceId = trim($this->new_device_id ?? '');

        if (empty($deviceId)) {
            Notification::make()
                ->title('Device ID Kosong')
                ->body('Harap masukkan Device ID yang ingin ditambahkan.')
                ->warning()
                ->send();
            return;
        }

        try {
            $response = Http::withBasicAuth(
                $this->wa_auth_user ?? config('gowaapi.user'),
                $this->wa_auth_pass ?? config('gowaapi.pass')
            )
                ->withHeaders([
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->timeout(15)
                ->post($baseUrl . '/devices', [
                    'device_id' => $deviceId,
                ]);

            $body = $response->json();

            $this->addDeviceResult = [
                'success'  => $response->successful(),
                'code'     => $body['code'] ?? ($response->successful() ? 'SUCCESS' : 'ERROR'),
                'message'  => $body['message'] ?? 'Tidak ada pesan dari server.',
                'device'   => $body['results'] ?? null,
            ];

            if ($response->successful()) {
                Notification::make()
                    ->title('Device Berhasil Ditambahkan')
                    ->body('Device ID: ' . $deviceId)
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('Gagal Menambahkan Device')
                    ->body($body['message'] ?? 'Terjadi kesalahan.')
                    ->danger()
                    ->send();
            }

        } catch (\Exception $e) {
            $this->addDeviceResult = [
                'success' => false,
                'code'    => 'ERROR',
                'message' => $e->getMessage(),
                'device'  => null,
            ];

            Notification::make()
                ->title('Gagal Menghubungi Server')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function dismissAddDeviceResult(): void
    {
        $this->addDeviceResult = null;
        $this->new_device_id = null;
    }

    // -- Login with QR Code --

    public function loginWithQrCode(): void
    {
        $baseUrl = rtrim($this->wa_api_base_url ?? config('gowaapi.base_url') ?? '', '/');

        if (empty($baseUrl)) {
            Notification::make()
                ->title('Base URL Kosong')
                ->body('Harap isi Base URL API terlebih dahulu.')
                ->warning()
                ->send();
            return;
        }

        $deviceId = $this->wa_device_id ?? config('gowaapi.device') ?? 'main';

        try {
            $response = Http::withBasicAuth(
                $this->wa_auth_user ?? config('gowaapi.user'),
                $this->wa_auth_pass ?? config('gowaapi.pass')
            )
                ->withHeaders([
                    'Accept'      => 'application/json',
                    'X-Device-Id' => $deviceId,
                ])
                ->timeout(30)
                ->get($baseUrl . '/app/login');

            $body = $response->json();

            if ($response->successful() && ($body['code'] ?? '') === 'SUCCESS') {
                $qrLink = $body['results']['qr_link'] ?? null;

                // If QR link is relative or localhost, build absolute URL from base
                if ($qrLink && !str_starts_with($qrLink, 'http')) {
                    $qrLink = $baseUrl . '/' . ltrim($qrLink, '/');
                }

                $this->qrCodeData = [
                    'success'     => true,
                    'qr_link'     => $qrLink,
                    'qr_duration' => $body['results']['qr_duration'] ?? 30,
                    'message'     => $body['message'] ?? 'QR Code berhasil diambil.',
                    'device_id'   => $deviceId,
                    'fetched_at'  => now()->format('H:i:s'),
                ];

                Notification::make()
                    ->title('QR Code Berhasil Diambil')
                    ->body('Scan QR Code di bawah untuk login WhatsApp. QR berlaku ' . ($body['results']['qr_duration'] ?? 30) . ' detik.')
                    ->success()
                    ->send();
            } else {
                $this->qrCodeData = [
                    'success'    => false,
                    'qr_link'    => null,
                    'message'    => $body['message'] ?? 'Gagal mengambil QR Code.',
                    'device_id'  => $deviceId,
                    'fetched_at' => now()->format('H:i:s'),
                ];

                Notification::make()
                    ->title('Gagal Mengambil QR Code')
                    ->body($body['message'] ?? 'Terjadi kesalahan.')
                    ->danger()
                    ->send();
            }

        } catch (\Exception $e) {
            $this->qrCodeData = [
                'success'    => false,
                'qr_link'    => null,
                'message'    => $e->getMessage(),
                'device_id'  => $deviceId,
                'fetched_at' => now()->format('H:i:s'),
            ];

            Notification::make()
                ->title('Gagal Menghubungi Server')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function refreshQrCode(): void
    {
        $this->loginWithQrCode();
    }

    public function dismissQrCode(): void
    {
        $this->qrCodeData = null;
    }
}
