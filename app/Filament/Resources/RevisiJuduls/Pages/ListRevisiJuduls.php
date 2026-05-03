<?php

namespace App\Filament\Resources\RevisiJuduls\Pages;

use App\Filament\Resources\RevisiJuduls\RevisiJudulResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRevisiJuduls extends ListRecords
{
    protected static string $resource = RevisiJudulResource::class;

    protected ?string $heading = 'Revisi Judul';

}
