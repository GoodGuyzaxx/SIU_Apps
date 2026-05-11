<?php

namespace App\Filament\Resources\RevisiJuduls\Pages;

use App\Filament\Resources\RevisiJuduls\RevisiJudulResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListRevisiJuduls extends ListRecords
{
    protected static string $resource = RevisiJudulResource::class;

    protected ?string $heading = 'Revisi Judul';

    public function getTabs(): array
    {
        return [
            'revisi' => Tab::make('Harus Direvisi')
                ->query(fn($query)=> $query->where('status_rev_judul', 'ya')),
            'sudah' => Tab::make('Sudah Direvisi')
                ->query(fn($query)=> $query->where('status_rev_judul', 'sudah_revisi')),
        ];
    }

}
