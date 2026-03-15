<?php

namespace App\Filament\Resources\Undangans\Pages;

use App\Filament\Resources\Undangans\UndanganResource;
use App\Services\WhatsappService;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUndangan extends EditRecord
{
    protected static string $resource = UndanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        // Jika draft baru saja diupload, cek syarat minimum dosen
        if ($record->softcopy_file_path && in_array($record->status_ujian, ['dijadwalkan', 'menunggu_acc'])) {
            $check = WhatsappService::checkMinimumRequirements($record->id);

            if ($check['terpenuhi']) {
                $record->update(['status_ujian' => 'ready_to_exam']);
                Notification::make()
                    ->title('Ujian Siap Dilaksanakan')
                    ->body('Syarat dosen terpenuhi dan draft sudah diupload. Status ujian diubah ke "Siap Ujian".')
                    ->success()
                    ->send();
            } elseif ($record->status_ujian !== 'draft_uploaded' && $record->status_ujian !== 'menunggu_acc') {
                $record->update(['status_ujian' => 'draft_uploaded']);
                Notification::make()
                    ->title('Draft Diupload')
                    ->body('Draft berhasil diupload. Menunggu ACC dosen yang cukup (min. 1 Pembimbing + 1 Penguji).')
                    ->info()
                    ->send();
            }
        }
    }
}
