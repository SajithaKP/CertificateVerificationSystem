<?php

namespace App\Filament\Resources\FieldSettingResource\Pages;

use App\Filament\Resources\FieldSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFieldSettings extends ListRecords
{
    protected static string $resource = FieldSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
