<?php

namespace App\Filament\Resources\FieldSettingResource\Pages;

use App\Filament\Resources\FieldSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFieldSetting extends EditRecord
{
    protected static string $resource = FieldSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
