<?php

namespace App\Filament\Resources\RevisiJuduls\Pages;

use App\Filament\Resources\RevisiJuduls\RevisiJudulResource;
use Filament\Resources\Pages\EditRecord;

class EditRevisiJudul extends EditRecord
{
    protected static string $resource = RevisiJudulResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function afterSave(): void
    {
        // Jika rev_judul sudah diisi, ubah status_rev_judul menjadi 'sudah_revisi'
        if (!empty($this->record->rev_judul)) {
            $this->record->update(['status_rev_judul' => 'sudah_revisi']);
        }
    }
}
