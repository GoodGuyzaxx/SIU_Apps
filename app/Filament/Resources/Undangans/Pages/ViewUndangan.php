<?php

namespace App\Filament\Resources\Undangans\Pages;

use App\Filament\Resources\Undangans\UndanganResource;
use App\Models\AccKesiapanUjian;
use App\Services\WhatsappService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Actions as SchemaActions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

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
                ->modalHeading('Preview Undangan')
                ->modalContent(fn () => view('filament.modals.pdf-preview', [
                    'url' => route('undangan.pdf', $dataId),
                ]))
                ->modalWidth('7xl')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Tutup'),
            Action::make('Kirim Undangan ke WhatsApp')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Kirim Undangan via WhatsApp')
                ->modalDescription('Kirim permintaan ACC kesiapan ujian ke semua dosen dan notifikasi upload softcopy ke mahasiswa via WhatsApp?')
                ->modalSubmitActionLabel('Ya, Kirim Sekarang')
                ->visible(fn () => $this->record->status_ujian === 'menunggu_acc')
                ->action(function (): void {
                    $accList = AccKesiapanUjian::where('id_undangan', $this->record->id)
                        ->get();

                    $waService = new WhatsappService();
                    $sentCount = 0;
                    $failCount = 0;

                    foreach ($accList as $acc) {
                        if ($waService->sendAccKesiapanRequest($acc)) {
                            $sentCount++;
                        } else {
                            $failCount++;
                        }
                    }

                    $softcopySent = $waService->sendSoftcopyRequestToMahasiswa($this->record);

                    if ($sentCount > 0 && $failCount === 0) {
                        Notification::make()
                            ->title('Undangan Berhasil Dikirim')
                            ->body("Permintaan ACC telah dikirim ke {$sentCount} dosen."
                                . ($softcopySent ? ' Mahasiswa juga telah dinotifikasi untuk upload softcopy.' : ''))
                            ->success()
                            ->send();
                    } elseif ($sentCount > 0 && $failCount > 0) {
                        Notification::make()
                            ->title('Undangan Sebagian Terkirim')
                            ->body("ACC terkirim ke {$sentCount} dosen, gagal {$failCount} dosen."
                                . ($softcopySent ? ' Mahasiswa telah dinotifikasi.' : ''))
                            ->warning()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Gagal Mengirim Undangan')
                            ->body('Semua pengiriman ACC gagal. Periksa koneksi WhatsApp Gateway.')
                            ->danger()
                            ->send();
                    }
                }),
            Action::make('Kirim Ulang Pesan Ke Dosen')
                ->icon('heroicon-o-paper-airplane')
                ->color('warning')
                ->requiresConfirmation()
                ->modalDescription('Kirim ulang permintaan ACC kesiapan ujian ke semua dosen yang belum merespon via WhatsApp?')
                ->modalSubmitActionLabel('Ya, Kirim Ulang')
                ->visible(fn () => $this->record->status_ujian === 'menunggu_acc')
                ->action(function (): void {
                    $accList = AccKesiapanUjian::where('id_undangan', $this->record->id)
                        ->where('status', 'pending')
                        ->get();

                    $waService = new WhatsappService();
                    $sentCount = 0;

                    foreach ($accList as $acc) {
                        if ($waService->sendAccKesiapanRequest($acc)) {
                            $sentCount++;
                        }
                    }

                    if ($sentCount > 0) {
                        Notification::make()
                            ->title("ACC Berhasil Dikirim Ulang ke {$sentCount} Dosen")
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Gagal Mengirim ACC')
                            ->body('Tidak ada dosen yang perlu dikirim ulang atau pengiriman gagal.')
                            ->danger()
                            ->send();
                    }
                }),
            Action::make('Kirim Pesan ke Mahasiswa')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('Kirim Ulang Notifikasi ke Mahasiswa')
                ->modalDescription('Kirim ulang pesan WhatsApp ke mahasiswa untuk mengingatkan upload softcopy / draft skripsi?')
                ->modalSubmitActionLabel('Ya, Kirim Sekarang')
                ->action(function (): void {
                    $waService = new WhatsappService();
                    $result = $waService->sendSoftcopyRequestToMahasiswa($this->record);

                    if ($result) {
                        Notification::make()
                            ->title('Pesan Berhasil Dikirim')
                            ->body('Notifikasi upload draft skripsi telah dikirim ke mahasiswa via WhatsApp.')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Gagal Mengirim Pesan')
                            ->body('Pesan gagal dikirim. Pastikan nomor HP mahasiswa sudah terdaftar.')
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }

    public function kirimWaPerDosen(int $accId): void
    {
        $acc = AccKesiapanUjian::with('dosen')->find($accId);

        if (!$acc) {
            Notification::make()
                ->title('Data tidak ditemukan')
                ->danger()
                ->send();
            return;
        }

        $waService = new WhatsappService();
        $result = $waService->sendAccKesiapanRequest($acc);

        if ($result) {
            Notification::make()
                ->title('Pesan Terkirim')
                ->body("Permintaan ACC kesiapan ujian berhasil dikirim ke {$acc->dosen->nama} via WhatsApp.")
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Gagal Mengirim Pesan')
                ->body("Pengiriman ke {$acc->dosen->nama} gagal. Pastikan nomor HP dosen sudah terdaftar.")
                ->danger()
                ->send();
        }
    }

    public function infolist(Schema $schema): Schema
    {
        $accList = AccKesiapanUjian::with('dosen')
            ->where('id_undangan', $this->record->id)
            ->get();

        $components = [];

        if ($accList->isNotEmpty()) {
            // Info syarat minimum
            $check = WhatsappService::checkMinimumRequirements($this->record->id);
            $syaratLabel = $check['terpenuhi'] ? '✅ Terpenuhi' : '⏳ Belum Terpenuhi';
            $syaratColor = $check['terpenuhi'] ? 'success' : 'warning';
            if ($check['tidak_mungkin']) {
                $syaratLabel = '❌ Tidak Dapat Terpenuhi';
                $syaratColor = 'danger';
            }

            $draftLabel = !empty($this->record->softcopy_file_path) ? '✅ Sudah Diupload' : '⏳ Belum Diupload';
            $draftColor = !empty($this->record->softcopy_file_path) ? 'success' : 'warning';

            $summaryComponents = [
                TextEntry::make('syarat_dosen')
                    ->label('Syarat Dosen (Min. 1 Pembimbing + 1 Penguji)')
                    ->default($syaratLabel)
                    ->badge()
                    ->color($syaratColor),

                TextEntry::make('syarat_draft')
                    ->label('Draft Mahasiswa')
                    ->default($draftLabel)
                    ->badge()
                    ->color($draftColor),

                TextEntry::make('info_pembimbing')
                    ->label('Pembimbing Setuju')
                    ->default("{$check['pembimbing_setuju']} disetujui, {$check['pembimbing_pending']} pending"),

                TextEntry::make('info_penguji')
                    ->label('Penguji Setuju')
                    ->default("{$check['penguji_setuju']} disetujui, {$check['penguji_pending']} pending"),
            ];

            $components[] = Section::make('Ringkasan Syarat Ujian')
                ->schema($summaryComponents)
                ->columns(2);

            // Detail ACC per dosen
            $accComponents = [];
            foreach ($accList as $index => $acc) {
                $roleLabel = WhatsappService::getRoleLabel($acc->role);
                $statusLabel = match ($acc->status) {
                    'pending' => '⏳ Menunggu',
                    'disetujui' => '✅ Setuju',
                    'ditolak' => '❌ Ditolak',
                    default => $acc->status,
                };
                $statusColor = match ($acc->status) {
                    'pending' => 'warning',
                    'disetujui' => 'success',
                    'ditolak' => 'danger',
                    default => 'gray',
                };

                $namaDosen = $acc->dosen->nama ?? '-';
                $accId = $acc->id;

                $itemComponents = [
                    TextEntry::make("acc_role_{$index}")
                        ->label('Peran')
                        ->default($roleLabel),

                    TextEntry::make("acc_nama_{$index}")
                        ->label('Nama Dosen')
                        ->default($namaDosen),

                    TextEntry::make("acc_status_{$index}")
                        ->label('Status ACC')
                        ->default($statusLabel)
                        ->badge()
                        ->color($statusColor),

                    TextEntry::make("acc_waktu_{$index}")
                        ->label('Waktu Respon')
                        ->default($acc->responded_at ? $acc->responded_at->format('d/m/Y H:i') : 'Belum merespon'),
                ];

                if ($acc->isRejected()) {
                    $itemComponents[] = TextEntry::make("acc_alasan_{$index}")
                        ->label('Alasan Penolakan')
                        ->default($acc->alasan_penolakan ?? '-')
                        ->columnSpanFull();
                }

                $itemComponents[] = TextEntry::make("acc_link_{$index}")
                    ->label('Link ACC')
                    ->default(route('acc.kesiapan.form', ['token' => $acc->token]))
                    ->copyable()
                    ->columnSpanFull();

                // Tombol kirim WA individual per dosen
                $itemComponents[] = SchemaActions::make([
                    Action::make("kirim_wa_dosen_{$index}")
                        ->label('Kirim WA ke Dosen Ini')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->modalHeading("Kirim WA ke {$namaDosen}")
                        ->modalDescription("Kirim permintaan ACC kesiapan ujian ke {$namaDosen} via WhatsApp?")
                        ->modalSubmitActionLabel('Ya, Kirim')
                        ->action(function () use ($accId): void {
                            $this->kirimWaPerDosen($accId);
                        }),
                ])->columnSpanFull();

                $accComponents[] = Section::make("Dosen {$roleLabel}")
                    ->schema($itemComponents)
                    ->columns(2)
                    ->collapsible();
            }

            $components[] = Section::make('Detail ACC Per Dosen')
                ->schema($accComponents);
        }

        return $schema->components($components);
    }
}
