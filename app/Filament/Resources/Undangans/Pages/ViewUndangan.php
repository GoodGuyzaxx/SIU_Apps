<?php

namespace App\Filament\Resources\Undangans\Pages;

use App\Filament\Resources\Undangans\UndanganResource;
use App\Models\AccKesiapanUjian;
use App\Models\Judul;
use App\Models\User;
use App\Services\WhatsappService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists;
use Filament\Infolists\Components\TextEntry;

class ViewUndangan extends ViewRecord
{
    protected static string $resource = UndanganResource::class;

    protected function getHeaderActions(): array
    {
        $dataId = $this->record->id;

        return [
            EditAction::make(),
            Action::make('Print')
            ->icon('heroicon-o-printer')
            ->color('success')
            ->url(fn() => route('undangan.pdf', $dataId)),
            Action::make('Kirim Ulang ACC')
            ->icon('heroicon-o-paper-airplane')
            ->color('warning')
            ->requiresConfirmation()
            ->modalDescription('Kirim ulang permintaan ACC kesiapan ujian ke Penguji 1 via WhatsApp?')
            ->modalSubmitActionLabel('Ya, Kirim Ulang')
            ->visible(fn() => $this->record->status_ujian === 'menunggu_acc')
            ->action(function (): void {
            $acc = AccKesiapanUjian::where('id_undangan', $this->record->id)->first();
            if ($acc) {
                $waService = new WhatsappService();
                $sent = $waService->sendAccKesiapanRequest($acc);
                if ($sent) {
                    Notification::make()
                        ->title('ACC Berhasil Dikirim Ulang')
                        ->success()
                        ->send();
                }
                else {
                    Notification::make()
                        ->title('Gagal Mengirim ACC')
                        ->body('Periksa konfigurasi WhatsApp API.')
                        ->danger()
                        ->send();
                }
            }
        }),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        $acc = AccKesiapanUjian::where('id_undangan', $this->record->id)->first();

        $components = [];

        // Tampilkan info ACC jika ada
        if ($acc) {
            $statusLabel = match ($acc->status) {
                    'pending' => '⏳ Menunggu Respon',
                    'disetujui' => '✅ Disetujui',
                    'ditolak' => '❌ Ditolak',
                    default => $acc->status,
                };

            $statusColor = match ($acc->status) {
                    'pending' => 'warning',
                    'disetujui' => 'success',
                    'ditolak' => 'danger',
                    default => 'gray',
                };

            $accComponents = [
                TextEntry::make('acc_status')
                ->label('Status ACC Penguji 1')
                ->default($statusLabel)
                ->badge()
                ->color($statusColor),

                TextEntry::make('acc_dosen')
                ->label('Penguji 1')
                ->default($acc->dosen->nama ?? '-'),

                TextEntry::make('acc_responded')
                ->label('Waktu Respon')
                ->default($acc->responded_at ? $acc->responded_at->format('d/m/Y H:i') : 'Belum merespon'),
            ];

            if ($acc->isRejected()) {
                $accComponents[] = TextEntry::make('acc_alasan')
                    ->label('Alasan Penolakan')
                    ->default($acc->alasan_penolakan ?? '-');
            }

            $accComponents[] = TextEntry::make('acc_link')
                ->label('Link ACC')
                ->default(route('acc.kesiapan.form', ['token' => $acc->token]))
                ->copyable();

            $components[] = Section::make('ACC Kesiapan Ujian')
                ->schema($accComponents)
                ->columns(2);
        }

        return $schema->components($components);
    }
}