<?php

namespace App\Filament\Resources\Undangans\Pages;

use App\Filament\Resources\Undangans\UndanganResource;
use App\Models\StatusUndangan;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUndangan extends CreateRecord
{
    protected static string $resource = UndanganResource::class;

    protected ?string $heading = 'Buat Undangan';

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResourceUrl('index');
    }

//    protected function handleRecordCreation(array $data): Model
//    {
//        $record = static::getModel()::create($data);
//
//        StatusUndangan::create([
//            'id_undangan' => $record->id,
//            'pembimbing_satu' => [],
//            'pembimbing_dua' => [],
//            'penguji_satu' => [],
//            'penguji_dua' => [],
//            'mahasiswa' => [],
//            'status' => 'pending',
//        ]);
//
//        return $record;
//    }

}
